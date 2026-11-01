<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base des modèles — accès PDO sécurisé (requêtes préparées uniquement).
 */
abstract class Model
{
    protected string $table = '';

    protected function db(): \PDO
    {
        return Database::pdo();
    }

    public function find(int|string $id): ?array
    {
        return Database::fetchOne("SELECT * FROM `{$this->table}` WHERE id = ? LIMIT 1", [$id]);
    }

    public function all(string $orderBy = 'id ASC', int $limit = 500): array
    {
        // $orderBy/$limit proviennent du code serveur uniquement, jamais du frontend.
        return Database::fetchAll("SELECT * FROM `{$this->table}` ORDER BY {$orderBy} LIMIT " . (int) $limit);
    }

    public function insert(array $row): int
    {
        $cols = array_keys($row);
        $sql  = sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s)',
            $this->table,
            '`' . implode('`, `', $cols) . '`',
            ':' . implode(', :', $cols)
        );
        Database::run($sql, $row);
        return Database::lastInsertId();
    }

    public function update(int $id, array $row): int
    {
        $sets = implode(', ', array_map(static fn ($c) => "`{$c}` = :{$c}", array_keys($row)));
        $row['id'] = $id;
        $stmt = Database::run("UPDATE `{$this->table}` SET {$sets} WHERE id = :id", $row);
        return $stmt->rowCount();
    }

    public function delete(int $id): int
    {
        return Database::run("DELETE FROM `{$this->table}` WHERE id = ?", [$id])->rowCount();
    }

    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) AS c FROM `{$this->table}`" . ($where !== '' ? " WHERE {$where}" : '');
        return (int) (Database::fetchOne($sql, $params)['c'] ?? 0);
    }

    /** Requête SQL écrite dans le modèle (code serveur uniquement, jamais depuis le frontend). */
    public static function query(string $sql, array $params = []): array
    {
        return Database::fetchAll($sql, $params);
    }

    public static function queryOne(string $sql, array $params = []): ?array
    {
        return Database::fetchOne($sql, $params);
    }
}
