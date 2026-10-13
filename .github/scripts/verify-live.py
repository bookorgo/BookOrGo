#!/usr/bin/env python3
"""Bounded same-origin HTTP verification for the P1-02 BookOrGo release."""

from __future__ import annotations

import json
import sys
from datetime import datetime, timezone
from html.parser import HTMLParser
from pathlib import Path
from urllib.error import HTTPError
from urllib.parse import urlsplit
from urllib.request import HTTPRedirectHandler, Request, build_opener

ORIGIN = "https://bookorgo.com"
OUTPUT = Path("site/test-results/live-http.json")


class SameOriginRedirect(HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        parsed = urlsplit(newurl)
        if parsed.scheme != "https" or parsed.netloc != "bookorgo.com":
            raise RuntimeError(f"Redirect outside approved origin: {newurl}")
        return super().redirect_request(req, fp, code, msg, headers, newurl)


class HeadParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.title = ""
        self.in_title = False
        self.h1_count = 0
        self.canonicals: list[str] = []
        self.robots: list[str] = []

    def handle_starttag(self, tag, attrs):
        values = dict(attrs)
        if tag == "title":
            self.in_title = True
        elif tag == "h1":
            self.h1_count += 1
        elif tag == "link" and "canonical" in values.get("rel", "").split():
            self.canonicals.append(values.get("href", ""))
        elif tag == "meta" and values.get("name", "").lower() == "robots":
            self.robots.append(values.get("content", ""))

    def handle_endtag(self, tag):
        if tag == "title":
            self.in_title = False

    def handle_data(self, data):
        if self.in_title:
            self.title += data


def fetch(path: str):
    request = Request(ORIGIN + path, headers={"User-Agent": "BookOrGoReleaseVerifier/1.0"})
    try:
        response = opener.open(request, timeout=25)
    except HTTPError as error:
        response = error
    with response:
        body = response.read(2_000_001)
        if len(body) > 2_000_000:
            raise AssertionError(f"Bounded response exceeded for {path}")
        return response.status, response.headers, body


opener = build_opener(SameOriginRedirect)
checks: list[dict] = []
failures: list[str] = []

pages = {
    "/": "Your next UAE",
    "/activities": "Activities sample catalogue",
    "/holidays": "Holidays sample catalogue",
    "/visas": "Visas sample catalogue",
    "/cruises": "Cruises sample catalogue",
    "/yachts": "Yachts sample catalogue",
    "/events": "Events sample catalogue",
    "/search?q=boat": "6 fictional cards",
    "/search?category=yachts&area=Dubai%20Marina&duration=under-2-hours&family=yes": "Marina yacht layout concept",
    "/search?q=sample&page=2": "Page 2 of 3",
    "/blog": "The travel journal",
}

for path, marker in pages.items():
    status, headers, body = fetch(path)
    text = body.decode("utf-8", "replace")
    parser = HeadParser()
    parser.feed(text)
    canonical_path = path.split("?", 1)[0]
    expected_canonical = ORIGIN + (canonical_path if canonical_path != "/" else "/")
    row = {
        "path": path,
        "status": status,
        "h1_count": parser.h1_count,
        "canonical": parser.canonicals,
        "robots": parser.robots,
        "x_robots_tag": headers.get("X-Robots-Tag", ""),
        "marker_present": marker in text,
    }
    checks.append(row)
    if status != 200:
        failures.append(f"{path}: expected 200, got {status}")
    if parser.h1_count != 1:
        failures.append(f"{path}: expected one H1, got {parser.h1_count}")
    if parser.canonicals != [expected_canonical]:
        failures.append(f"{path}: unexpected canonical {parser.canonicals}")
    if "noindex, nofollow" not in [value.lower() for value in parser.robots]:
        failures.append(f"{path}: missing meta noindex")
    if headers.get("X-Robots-Tag", "").lower() != "noindex, nofollow":
        failures.append(f"{path}: missing HTTP noindex")
    if marker not in text:
        failures.append(f"{path}: expected page marker missing")
    if path.startswith(("/activities", "/holidays", "/visas", "/cruises", "/yachts", "/events", "/search")):
        if "Demonstration data only." not in text:
            failures.append(f"{path}: missing fictional sample disclosure")
        if "No live offer or price" not in text:
            failures.append(f"{path}: missing no-offer card state")

status, headers, body = fetch("/search?category=hotels")
text = body.decode("utf-8", "replace")
checks.append({"path": "/search?category=hotels", "status": status, "safe_error": "We couldn’t apply those filters" in text})
if status != 422 or "We couldn’t apply those filters" not in text:
    failures.append("invalid catalogue filter did not return the safe 422 state")
if headers.get("X-Robots-Tag", "").lower() != "noindex, nofollow":
    failures.append("invalid catalogue filter lost HTTP noindex")

status, _, body = fetch("/definitely-not-a-bookorgo-route")
checks.append({"path": "/definitely-not-a-bookorgo-route", "status": status})
if status != 404 or b"APP_KEY" in body:
    failures.append("unknown path did not return a safe 404")

for path in ["/.env", "/composer.json", "/artisan", "/vendor/autoload.php", "/storage/logs/laravel.log"]:
    status, _, body = fetch(path)
    checks.append({"path": path, "status": status, "bytes": len(body)})
    if status not in (403, 404):
        failures.append(f"{path}: sensitive path returned {status}")

manifest = json.loads(Path("site/public/build/manifest.json").read_text())
for item in manifest.values():
    asset = "/build/" + item["file"]
    status, headers, body = fetch(asset)
    checks.append({"path": asset, "status": status, "bytes": len(body), "content_type": headers.get("Content-Type", "")})
    if status != 200 or not body:
        failures.append(f"{asset}: built asset unavailable")
    content_type = headers.get("Content-Type", "").lower()
    if asset.endswith(".css") and "text/css" not in content_type:
        failures.append(f"{asset}: unexpected CSS MIME {content_type}")
    if asset.endswith(".js") and "javascript" not in content_type:
        failures.append(f"{asset}: unexpected JavaScript MIME {content_type}")

report = {
    "task": "P1-02-main-release",
    "checked_at": datetime.now(timezone.utc).isoformat(),
    "origin": ORIGIN,
    "checks": checks,
    "failures": failures,
    "limits": [
        "Same-origin bounded HTTP checks only",
        "No indexing release, supplier, payment, database or scheduler change",
    ],
}
OUTPUT.parent.mkdir(parents=True, exist_ok=True)
OUTPUT.write_text(json.dumps(report, indent=2) + "\n")
print(json.dumps({"checks": len(checks), "failures": len(failures)}))
if failures:
    print("\n".join(failures), file=sys.stderr)
    raise SystemExit(1)
