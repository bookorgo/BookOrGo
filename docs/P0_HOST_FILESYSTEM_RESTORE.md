# P0-L04c Hostinger filesystem restore proof

Date: 12 October 2026 (Asia/Karachi)  
Status: **PASS_FILESYSTEM_ONLY**  
Tested revision: `1cb06b2f3535b1a9e2978df4ef9e6b726ec7124f`  
Successful run: https://github.com/bookorgo/BookOrGo/actions/runs/38227821932

## Scope

This bounded test proves a reversible file archive/restore cycle on the actual Hostinger account without reading, changing or deleting any pre-existing file. It does not deploy BookOrGo and does not access a database.

## Guarded sequence

1. Capture a SHA-256 fingerprint of document-root top-level names and file types only.
2. Create one cryptographically random, mode-700 temporary directory under the verified document root.
3. Add explicit HTTP-denial rules and generate one random test payload.
4. Record the payload hash, create a tar.gz archive and reject any archive entry outside the two expected files.
5. Delete only the generated source files and empty source directory.
6. Restore into a separate generated directory and compare source/restored hashes.
7. Verify direct HTTPS access is denied/not found.
8. Remove each known generated file, then remove only empty generated directories.
9. Assert the temporary path is absent and the top-level fingerprint equals the original value.

## Result

| Check | Evidence | Result |
| --- | --- | --- |
| Archive created | 330-byte tar.gz | PASS |
| Archive entries | only `.htaccess` and `payload.txt` | PASS |
| Restore integrity | source/restored SHA-256 identical | PASS |
| Public protection | HTTPS returned 404 | PASS |
| Cleanup | temporary path absent | PASS |
| Existing-root preservation | top-level fingerprint restored | PASS |
| Existing file contents read | zero | PASS |
| Database touched | false | PASS |
| Deployment | none | NOT RUN |

Artifact 11737430400 contains the bounded JSON proof. Artifact digest: `sha256:f31d389ca1d3f3694568ff496295e7e1fef0b2cb0adac7ef4da61ee1c6e39369`.

## Requirements mapping

- Master Requirements V3.1 §10: tested restore appropriate to hosting.
- Master Requirements V3.1 §25.1–25.3 P0-T02/P0-T04: storage/backup constraints and restore evidence before release.
- AI Execution Playbook V4.1 §2A.2/§2A.3 P0-L04: record backup/restore proof without production migration.
- PHASE_ROADMAP P0-L04: backup and restore evidence.

## Honest limitations

This proves only a generated filesystem payload. It does not prove MySQL export/import, Laravel release rollback, storage-link behavior, protected browser rendering or hPanel cron execution. The isolated host database needs the six previously recorded dedicated secrets; hPanel scheduler configuration needs observable hPanel access or a separately authorized verified scheduler setup.
