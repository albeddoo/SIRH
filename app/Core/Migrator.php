<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Moteur de migrations forward-only (D-21 : script maison, aucune dépendance).
 *
 * - Fichiers SQL dans database/migrations/, nommés AAAA_MM_OO_description.sql
 *   (ordre lexical = ordre d'application).
 * - Table technique `migrations` (cf. catalogue 04_MODELE_DONNEES.md, classée
 *   technique d'infrastructure) : mémorise les fichiers appliqués + checksum SHA-256.
 * - Reproductibilité : une base vierge peut être reconstruite en rejouant
 *   tous les fichiers (exigence T-33, adaptée au poste unique via D-26).
 * - Un fichier = un lot de statements séparés par ";\n" en début de ligne.
 */
final class Migrator
{
    public function __construct(
        private readonly \PDO $pdo,
        private readonly string $migrationsDir,
    ) {
    }

    /** Crée la table technique si absente (identique à la migration 0001). */
    public function ensureTable(): void
    {
        $this->pdo->exec(<<<'SQL'
            CREATE TABLE IF NOT EXISTS migrations (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL UNIQUE,
                checksum CHAR(64) NOT NULL,
                applied_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL);
    }

    /** @return list<string> fichiers déjà appliqués */
    public function applied(): array
    {
        return array_column(
            $this->pdo->query('SELECT filename FROM migrations ORDER BY filename')->fetchAll(),
            'filename'
        );
    }

    /** @return list<string> fichiers .sql triés, présents sur disque */
    public function pendingFiles(): array
    {
        $files = glob($this->migrationsDir . '/*.sql') ?: [];
        sort($files, SORT_STRING);
        $applied = $this->applied();
        return array_values(array_filter(
            $files,
            static fn ($f) => !in_array(basename($f), $applied, true)
        ));
    }

    /** Applique toutes les migrations en attente, chacune dans sa transaction. */
    public function migrate(?callable $log = null): int
    {
        $count = 0;
        foreach ($this->pendingFiles() as $file) {
            $name = basename($file);
            $sql  = file_get_contents($file);
            if ($sql === false) {
                throw new \RuntimeException("Lecture impossible : {$name}");
            }

            // Note : les DDL MySQL/MariaDB sont auto-committés (pas de rollback
            // possible sur CREATE TABLE) ; la transaction protège les DML.
            $this->pdo->beginTransaction();
            try {
                foreach ($this->splitStatements($sql) as $statement) {
                    $this->pdo->exec($statement);
                }
                $this->pdo->prepare('INSERT INTO migrations (filename, checksum, applied_at) VALUES (?, ?, UTC_TIMESTAMP())')
                    ->execute([$name, hash('sha256', $sql)]);
                if ($this->pdo->inTransaction()) {
                    $this->pdo->commit();
                }
                $count++;
                if ($log !== null) {
                    $log("✔ appliquée : {$name}");
                }
            } catch (\Throwable $e) {
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                throw new \RuntimeException("Échec migration {$name} : " . $e->getMessage(), 0, $e);
            }
        }
        return $count;
    }

    /** État pour diagnostic / page d'état Admin (A-18). */
    public function status(): array
    {
        return [
            'applied'  => $this->applied(),
            'pending'  => array_map('basename', $this->pendingFiles()),
            'database' => $this->currentVersion(),
        ];
    }

    public function currentVersion(): ?string
    {
        $row = $this->pdo->query('SELECT filename FROM migrations ORDER BY filename DESC LIMIT 1')->fetch();
        return $row['filename'] ?? null;
    }

    /** Sépare les statements SQL (le splitter ignore les "DELIMITER", non utilisés). */
    private function splitStatements(string $sql): array
    {
        // Retire les commentaires de ligne -- et /* */ simples.
        $sql = preg_replace('/^\s*--.*$/m', '', $sql) ?? $sql;
        $parts = preg_split('/;\s*\n/', $sql) ?: [];
        return array_values(array_filter(
            array_map('trim', $parts),
            static fn ($s) => $s !== '' && $s !== ';'
        ));
    }
}
