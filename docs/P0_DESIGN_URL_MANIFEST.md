# P0 design, asset and prior-URL manifest

Task: P0-L01b  
Verified: 12 October 2026 03:09 UTC  
Status: PASS for inventory and migration planning only. This is not design approval, asset approval, a content migration or a release decision.

## Fresh-build boundary

BookOrGo will be implemented as a brand-new Laravel application. The earlier ChatGPT Site is a read-only URL and information-architecture reference only. Its code, copy, records and assets must not be imported into the Laravel application. Existing Site files, access, URLs and Hostinger files remain unchanged until a separately reviewed release and rollback plan is approved.

## Design adaptation map

| Surface | Approved direction to carry into fresh design | Explicit exclusions |
| --- | --- | --- |
| Global shell | BookOrGo identity; navy/blue base; restrained yellow accent; clear six-category navigation; Dubai/UAE-first positioning; responsive, accessible header and footer | Do not copy competitor branding, UI pixel-for-pixel, claims or global-destination demo content |
| Homepage | Strong hero and search entry point; destination/category discovery; trust/disclosure space; editorial and newsletter areas | Do not carry forward reference prices, ratings, availability, photos or unverified promotional claims |
| Listing | Search context, breadcrumb/H1, filters, sorting, result cards, pagination/loading states and helpful content modules | Do not copy Booking.com brand assets, card content, reviews, prices or photos |
| Detail | Breadcrumb, title, media area, overview, logistics, FAQ, location context and a clearly disclosed partner-referral action | No own checkout, fabricated availability/price/reviews, copied map/media or unsupported structured data |
| Blog | Server-rendered hub and article templates with useful UAE-first editorial content and source/freshness metadata | No thin SEO pages, copied reference text or indexation before release gates pass |

The visual references are structural inspiration. The fresh implementation must establish its own responsive components and tokens rather than reproduce screenshots.

## Asset and rights register

| Asset/source | Inventory result | Implementation rule |
| --- | --- | --- |
| Owner homepage reference PDF | Two pages inspected; shows BookOrGo visual direction and logo treatment | Reference only. Do not publish PDF contents or extract embedded imagery |
| Owner listing reference PDF | Two pages inspected; third-party marketplace layout reference | Structure only. Do not use third-party branding, copy, prices, reviews or media |
| Owner detail reference PDF | Two pages inspected; third-party product-detail layout reference | Structure only. Do not use third-party branding, copy, maps, prices, reviews or media |
| BookOrGo logo | Visible in the homepage reference, but no separate original file or rights record was verified | BLOCKED for production asset use until an owner-supplied/verified original is available |
| Photography/illustration | No reusable, rights-verified source package was found in this bounded inventory | Use placeholders only in protected drafts; obtain provenance and rights before public release |
| Fonts | Exact font files and licence register were not provided | Select licence-safe web fonts or record owner-approved font licences before release |
| Earlier Site assets | Source and licence provenance were not independently verified | Do not import into the Laravel build |

## Prior public URL manifest

The following paths were observed on the existing public ChatGPT Site. They are preservation candidates for the Laravel router; they are not approval to migrate the old content.

| Path | Planned fresh template | Current observation |
| --- | --- | --- |
| `/` | Homepage | `noindex,nofollow`; canonical absent |
| `/about/` | Static page | `noindex,nofollow`; canonical absent |
| `/activities/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/holidays/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/visas/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/cruises/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/yachts/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/events/` | Category/listing | `noindex,nofollow`; canonical absent |
| `/blog/` | Blog hub | `noindex,nofollow`; canonical absent |
| `/activities/dubai/skyline/` | Activity detail | `noindex,nofollow`; canonical absent |
| `/activities/dubai/desert/` | Activity detail | `noindex,nofollow`; canonical absent |
| `/cruises/dubai/marina-cruise/` | Cruise detail | `noindex,nofollow`; canonical absent |
| `/yachts/dubai/yacht-day/` | Yacht detail | `noindex,nofollow`; canonical absent |
| `/holidays/uae-staycation/` | Holiday detail | `noindex,nofollow`; canonical absent |
| `/visas/visitor-information/` | Visa information detail | `noindex,nofollow`; canonical absent |
| `/events/dubai/culture-calendar/` | Event detail | `noindex,nofollow`; canonical absent |
| `/blog/dubai/plan-your-first-visit/` | Blog article | `noindex,nofollow`; canonical absent |
| `/disclosure/` | Legal/disclosure | `noindex,nofollow`; canonical absent |
| `/privacy/` | Legal | `noindex,nofollow`; canonical absent |
| `/terms/` | Legal | `noindex,nofollow`; canonical absent |
| `/contact/` | Contact | `noindex,nofollow`; canonical absent |

Observed filter states `/activities/?category=all`, `/activities/?area=Dubai` and `/holidays/?area=Ras%20Al%20Khaimah` are query states, not separate canonical routes. Fragment identifiers used inside detail/article pages are not separate URLs.

## Migration and SEO policy

- Preserve compatible path shapes when fresh P1 templates are introduced; record every intentional change in a redirect/canonical map before cutover.
- Keep all fresh sample/draft pages labelled and `noindex` until the verified-page release gates pass.
- Do not add canonicals, redirects, sitemap entries or indexing requests for routes that have not passed content, rights and source verification.
- Treat `bookorgo.com` and the ChatGPT Site as separate currently observed surfaces. Custom-domain routing to these preview paths has not been verified.
- Do not change DNS, the existing Site audience, or live indexation as part of this task.

## Requirement mapping

- Master Requirements V3.1: business/UX principles and six verticals (sections 01–04), core public templates (section 03), blog (section 17), architecture and Phase 0 controls (section 25).
- AI Execution Playbook V4.1: P0-L01 inventory/migration map and the design inputs required before P1 template packages.
- Kickoff: fresh-build boundary, evidence-first gates, preserved production state and no fabricated commercial data.

## Verification and limitations

- Rendered and visually inspected all six pages across the three owner reference PDFs.
- Loaded 21 of 21 observed Site routes: all exposed `noindex,nofollow`; zero exposed a canonical tag.
- Recorded three observed query-string states separately from canonical route candidates.
- No old code or assets were downloaded into the application, and no Site, Hostinger, DNS or audience setting was changed.
- Logo originals, font licensing, media rights, custom-domain route parity and final design tokens remain unresolved.

Next: P0-L02b web PHP/origin/document-root/SSL proof and host resource/upload constraints. P1 route implementation remains gated on the protected Laravel scaffold and design/asset decisions.
