<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Connexion PDO MySQL/MariaDB — singleton de connexion.
 * ERRMODE_EXCEPTION + vraies requêtes préparées (EMULATE_PREPARES=false).
 * Aucun SQL ne peut provenir du frontend (exigence qualité §7).
 */
final class Database
{
    private static ?\PDO $pdo = null;
    /** @var array<string, mixed> */
    private static array $config = [];

    public static function configure(array $dbConfig): void
    {
        self::$config = $dbConfig;
    }

    public static function pdo(): \PDO
    {
        if (self::$pdo instanceof \PDO) {
            return self::$pdo;
        }

        $c = self::$config;
        // Option locale (sandbox/dev) : DB_SOCKET permet une connexion par socket unix.
        // Sur WampServer Windows, cette variable reste vide -> DSN TCP host:port standard.
        if (!empty($c['socket'] ?? '')) {
            $dsn = sprintf('mysql:unix_socket=%s;dbname=%s;charset=%s', $c['socket'], $c['database'], $c['charset']);
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $c['host'],
                $c['port'],
                $c['database'],
                $c['charset']
            );
        }

        try {
            self::$pdo = new \PDO($dsn, $c['username'], $c['password'], $c['options']);
            // Dates stockées en UTC en base (MP i18n) : session en +00:00.
            self::$pdo->exec("SET time_zone = '+00:00'");
        } catch (\PDOException $e) {
            Logger::error('Connexion BD échouée : ' . $e->getMessage());
            throw new \RuntimeException(
                'Base de données inaccessible. Vérifiez WampServer (MySQL/MariaDB démarré) et config/.env.',
                0,
                $e
            );
        }

        return self::$pdo;
    }

    /** Requête préparée + exécution sécurisée. Retourne PDOStatement. */
    public static function run(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $row = self::run($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::run($sql, $params)->fetchAll();
    }

    public static function lastInsertId(): int
    {
        return (int) self::pdo()->lastInsertId();
    }
}
