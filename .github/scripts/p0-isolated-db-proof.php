<?php

declare(strict_types=1);

const ISOLATION_CONFIRMATION = 'ISOLATED_EPHEMERAL_DATABASE';

function requiredEnvironment(string $name): string
{
    $value = getenv($name);

    if ($value === false || $value === '') {
        throw new RuntimeException('Missing required environment variable: ' . $name);
    }

    return $value;
}

function tableExists(PDO $pdo, string $database, string $table): bool
{
    $statement = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = :schema AND table_name = :table'
    );
    $statement->execute(['schema' => $database, 'table' => $table]);

    return (int) $statement->fetchColumn() === 1;
}

try {
    $confirmation = requiredEnvironment('BOOKORGO_P0_DB_CONFIRM');
    if (!hash_equals(ISOLATION_CONFIRMATION, $confirmation)) {
        throw new RuntimeException('Isolation confirmation did not match.');
    }

    $host = requiredEnvironment('DB_HOST');
    $port = requiredEnvironment('DB_PORT');
    $database = requiredEnvironment('DB_DATABASE');
    $username = requiredEnvironment('DB_USERNAME');
    $password = requiredEnvironment('DB_PASSWORD');
    $runId = preg_replace('/[^a-zA-Z0-9_]/', '_', requiredEnvironment('BOOKORGO_P0_RUN_ID'));

    if (!preg_match('/(?:^|_)(?:p0|smoke|isolated)(?:_|$)/i', $database)) {
        throw new RuntimeException('Database name does not carry an isolation marker.');
    }

    if ($runId === null || $runId === '') {
        throw new RuntimeException('Run identifier is invalid.');
    }

    $table = substr('bookorgo_p0_probe_' . strtolower($runId), 0, 63);
    if (!preg_match('/^[a-z0-9_]+$/', $table)) {
        throw new RuntimeException('Generated table name is invalid.');
    }

    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database),
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    if (tableExists($pdo, $database, $table)) {
        throw new RuntimeException('Unique smoke table already exists; refusing to overwrite it.');
    }

    $created = false;

    try {
        $pdo->exec(sprintf(
            'CREATE TABLE %s (
                id CHAR(36) NOT NULL,
                marker CHAR(64) NOT NULL,
                state VARCHAR(32) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY uq_marker (marker)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci',
            $table
        ));
        $created = true;

        $id = sprintf(
            '%s-%s-%s-%s-%s',
            bin2hex(random_bytes(4)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(6))
        );
        $marker = hash('sha256', $id . random_bytes(16));

        $insert = $pdo->prepare(sprintf(
            'INSERT INTO %s (id, marker, state) VALUES (:id, :marker, :state)',
            $table
        ));
        $insert->execute(['id' => $id, 'marker' => $marker, 'state' => 'created']);

        $read = $pdo->prepare(sprintf(
            'SELECT marker, state FROM %s WHERE id = :id',
            $table
        ));
        $read->execute(['id' => $id]);
        $initial = $read->fetch();
        if ($initial !== ['marker' => $marker, 'state' => 'created']) {
            throw new RuntimeException('Inserted row did not round-trip.');
        }

        $update = $pdo->prepare(sprintf(
            'UPDATE %s SET state = :state WHERE id = :id',
            $table
        ));
        $update->execute(['state' => 'updated', 'id' => $id]);

        $read->execute(['id' => $id]);
        $updated = $read->fetch();
        if ($updated !== ['marker' => $marker, 'state' => 'updated']) {
            throw new RuntimeException('Updated row did not round-trip.');
        }

        $delete = $pdo->prepare(sprintf('DELETE FROM %s WHERE id = :id', $table));
        $delete->execute(['id' => $id]);

        $count = (int) $pdo->query(sprintf('SELECT COUNT(*) FROM %s', $table))->fetchColumn();
        if ($count !== 0) {
            throw new RuntimeException('Smoke row cleanup failed.');
        }
    } finally {
        if ($created) {
            $pdo->exec(sprintf('DROP TABLE IF EXISTS %s', $table));
        }
    }

    if (tableExists($pdo, $database, $table)) {
        throw new RuntimeException('Smoke table still exists after cleanup.');
    }

    $serverVersion = (string) $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    $report = [
        'task' => 'P0-L04a',
        'scope' => 'isolated_smoke_database',
        'driver' => (string) $pdo->getAttribute(PDO::ATTR_DRIVER_NAME),
        'server_family' => stripos($serverVersion, 'mariadb') !== false ? 'MariaDB' : 'MySQL-compatible',
        'server_version' => $serverVersion,
        'checks' => [
            'connect' => true,
            'create_table' => true,
            'insert' => true,
            'read' => true,
            'update' => true,
            'delete' => true,
            'drop_table' => true,
            'cleanup_verified' => true,
        ],
        'database_identity_logged' => false,
        'deployment' => 'none',
    ];

    $json = json_encode($report, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    $reportPath = getenv('REPORT_PATH');
    if ($reportPath !== false && $reportPath !== '') {
        file_put_contents($reportPath, $json . PHP_EOL, LOCK_EX);
    }

    echo 'P0_L04A_DB_JSON=', json_encode($report, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR), PHP_EOL;
} catch (Throwable $throwable) {
    fwrite(STDERR, 'P0-L04a proof failed safely: ' . $throwable::class . PHP_EOL);
    exit(1);
}
