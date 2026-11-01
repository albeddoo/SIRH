<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Journal d'audit (table audit_logs, migration 0003) — traçabilité loi 09-08 / MP §24.17.
 * Écriture best-effort : un échec d'audit ne casse pas l'action métier, mais est loggé.
 */
final class Audit
{
    public static function log(string $action, ?string $entityType = null, ?int $entityId = null, array $payload = []): void
    {
        try {
            // Colonnes réelles de audit_logs (migration 0003) — aucune colonne inventée.
            Database::run(
                'INSERT INTO audit_logs (user_id, action, target_table, target_id, new_values_json, ip_address, result, details)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    Auth::id(),
                    mb_substr($action, 0, 120),
                    $entityType !== null ? mb_substr($entityType, 0, 80) : null,
                    $entityId !== null ? (string) $entityId : null,
                    $payload === [] ? null : json_encode($payload, JSON_UNESCAPED_UNICODE),
                    $_SERVER['REMOTE_ADDR'] ?? 'cli',
                    'success',
                    null,
                ]
            );
        } catch (\Throwable $e) {
            Logger::error('Audit impossible: ' . $e->getMessage(), ['action' => $action]);
        }
    }
}
