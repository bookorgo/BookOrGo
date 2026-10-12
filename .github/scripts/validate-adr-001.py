#!/usr/bin/env python3
"""Validate ADR-001's machine-readable decision and markdown status."""

from __future__ import annotations

import json
import sys
from pathlib import Path


ROOT = Path(__file__).resolve().parents[2]
EVIDENCE_PATH = ROOT / "docs" / "evidence" / "ADR-001.json"
MARKDOWN_PATH = ROOT / "docs" / "ADR-001-laravel-hostinger.md"

ALLOWED_STATUSES = {
    "PASS",
    "PASS_CI_ONLY",
    "PASS_FILESYSTEM_ONLY",
    "BLOCKED",
    "NOT_RUN",
}
SCOPED_PASS_STATUSES = {"PASS_CI_ONLY", "PASS_FILESYSTEM_ONLY"}
REQUIRED_BLOCKERS = {
    "HOST-DB",
    "DB-RESTORE",
    "HOST-SCHEDULER",
    "DURABLE-STORAGE",
    "HOST-HTTP",
    "ASSET-RIGHTS",
}


def fail(message: str) -> None:
    raise AssertionError(message)


def main() -> int:
    data = json.loads(EVIDENCE_PATH.read_text(encoding="utf-8"))
    markdown = MARKDOWN_PATH.read_text(encoding="utf-8")

    if data.get("decision_id") != "ADR-001":
        fail("decision_id must be ADR-001")
    if data.get("task_id") != "P0-L05":
        fail("task_id must be P0-L05")
    if data.get("overall_status") != "BLOCKED":
        fail("overall_status must honestly remain BLOCKED")
    if "- Status: BLOCKED" not in markdown:
        fail("ADR markdown must contain '- Status: BLOCKED'")

    matrix = data.get("matrix")
    if not isinstance(matrix, list) or not matrix:
        fail("matrix must be a non-empty list")

    ids: list[str] = []
    blocked: set[str] = set()
    for item in matrix:
        item_id = item.get("id")
        status = item.get("status")
        if not isinstance(item_id, str) or not item_id:
            fail("every matrix item needs a non-empty string id")
        ids.append(item_id)
        if status not in ALLOWED_STATUSES:
            fail(f"{item_id}: unsupported status {status!r}")
        if status == "PASS" and not item.get("evidence"):
            fail(f"{item_id}: PASS requires evidence")
        if status in SCOPED_PASS_STATUSES:
            if not item.get("evidence"):
                fail(f"{item_id}: scoped pass requires evidence")
            if not item.get("limitation"):
                fail(f"{item_id}: scoped pass requires a limitation")
        if status in {"BLOCKED", "NOT_RUN"} and not item.get("limitation"):
            fail(f"{item_id}: {status} requires a limitation")
        if status == "BLOCKED":
            blocked.add(item_id)

    if len(ids) != len(set(ids)):
        fail("matrix item IDs must be unique")
    if not blocked:
        fail("BLOCKED decision requires at least one blocked gate")

    declared = set(data.get("required_blockers", []))
    if not REQUIRED_BLOCKERS.issubset(declared):
        fail("required_blockers is missing one or more mandatory gate IDs")
    if not REQUIRED_BLOCKERS.issubset(blocked):
        fail("mandatory blocker IDs must have BLOCKED matrix status")

    deployment = data.get("deployment")
    if not isinstance(deployment, dict) or deployment.get("performed") is not False:
        fail("deployment.performed must be false")

    print(
        json.dumps(
            {
                "decision_id": data["decision_id"],
                "overall_status": data["overall_status"],
                "matrix_items": len(matrix),
                "blocked_items": sorted(blocked),
                "deployment_performed": False,
            },
            sort_keys=True,
        )
    )
    return 0


if __name__ == "__main__":
    try:
        raise SystemExit(main())
    except (AssertionError, json.JSONDecodeError, OSError) as exc:
        print(f"ADR-001 validation failed: {exc}", file=sys.stderr)
        raise SystemExit(1)
