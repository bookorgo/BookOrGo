# P0 isolated database proof harness

Task: P0-L04a-prep  
Verified: 12 October 2026 07:21 UTC  
Status: PASS for the isolated migration/CRUD harness; BLOCKED for the Hostinger database proof because dedicated smoke-database credentials are not configured.

## Completed

The repository now contains a reusable PDO MySQL/MariaDB proof at .github/scripts/p0-isolated-db-proof.php and an approval-gated workflow at .github/workflows/p0-isolated-db-proof.yml.

The harness refuses to connect unless:

- BOOKORGO_P0_DB_CONFIRM exactly equals ISOLATED_EPHEMERAL_DATABASE.
- The selected database name contains an explicit p0, smoke or isolated marker.
- All host, port, database, username and password inputs are present.
- Its unique run-specific table does not already exist.

It creates one run-specific InnoDB table, inserts and reads a random record, updates and reads it again, deletes the row, drops the table and verifies that the table no longer exists. It never logs the database, host, username, password or random marker.

## Verified CI result

GitHub Actions run 38217201832 passed on PHP 8.3 and MariaDB 11.4.13. The following checks passed:

- Connection
- Reversible table creation
- Insert
- Read
- Update
- Delete
- Table drop
- Post-run cleanup verification

Artifact p0-l04a-db-harness (ID 11732595166) was retained for 30 days with digest sha256:17e522233f5165dcdd9e4c74c30c3c59ab271d66a50247f606a5ff0b42d1c8eb.

This proves the harness, not Hostinger database capacity or credentials.

## Exact Hostinger blocker

The same run checked secret readiness without printing any values. These dedicated inputs are absent:

- BOOKORGO_P0_DB_HOST
- BOOKORGO_P0_DB_PORT
- BOOKORGO_P0_DB_DATABASE
- BOOKORGO_P0_DB_USERNAME
- BOOKORGO_P0_DB_PASSWORD
- BOOKORGO_P0_DB_CONFIRM

The Hostinger job is manual-dispatch only and was skipped. It must use a newly isolated database/user; an unknown or existing production database is not acceptable. BOOKORGO_P0_DB_CONFIRM must be set to ISOLATED_EPHEMERAL_DATABASE.

## Safety and scope

- No Hostinger database connection was attempted.
- No existing database, table, production file, DNS, public route, Site or audience was changed.
- Database credentials never enter the repository or logs.
- Host execution transports credentials only through the encrypted SSH session and removes its local/remote temporary scripts.
- The workflow cannot run the Hostinger proof on a normal push.

## Requirements checked

- Master Requirements V3.1 section 25.3 P0-T04: protected database migration/read/write proof and captured evidence.
- AI Execution Playbook V4.1 sections 2A.2 and 2A.3 P0-L04: explicitly selected environment, reversible migration and no unapproved production change.
- Kickoff: protected smoke test, secret protection and honest PASS/FAIL/BLOCKED reporting.

## Remaining evidence

P0-L04a remains BLOCKED for Hostinger until the six dedicated inputs exist and a manual proof succeeds. Backup/restore is a separate P0-L04b gate and is not implied by this CRUD harness.

Independent next work: P0-L04b protected Blade/SEO smoke views, built assets and scheduler/backup preparation that does not require these database credentials.
