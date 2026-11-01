<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/** Modèle users (migration 0002). */
final class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return Database::fetchOne('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
    }

    /** @return list<array> utilisateurs actifs avec leurs rôles */
    public function listWithRoles(): array
    {
        $users = Database::fetchAll(
            "SELECT u.*, c.name AS company_name
             FROM users u LEFT JOIN companies c ON c.id = u.company_id
             WHERE u.archived_at IS NULL
             ORDER BY u.last_name, u.first_name"
        );
        $roles = Database::fetchAll(
            'SELECT ur.user_id, r.code, r.name FROM user_roles ur JOIN roles r ON r.id = ur.role_id'
        );
        $byUser = [];
        foreach ($roles as $r) {
            $byUser[$r['user_id']][] = $r['name'] . ' (' . $r['code'] . ')';
        }
        foreach ($users as &$u) {
            $u['role_names'] = $byUser[$u['id']] ?? [];
        }
        return $users;
    }

    public function attachRole(int $userId, int $roleId, ?int $grantedBy = null): void
    {
        Database::run(
            'INSERT INTO user_roles (user_id, role_id, granted_by) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE granted_by = VALUES(granted_by)',
            [$userId, $roleId, $grantedBy]
        );
    }

    public function detachRole(int $userId, int $roleId): void
    {
        Database::run('DELETE FROM user_roles WHERE user_id = ? AND role_id = ?', [$userId, $roleId]);
    }

    /** Sessions actives non révoquées d'un utilisateur (révocation admin). */
    public function activeSessions(int $userId): array
    {
        return Database::fetchAll(
            'SELECT id, ip_address, user_agent, last_activity_at, expires_at
             FROM sessions WHERE user_id = ? AND revoked_at IS NULL AND expires_at > ?
             ORDER BY last_activity_at DESC',
            [$userId, gmdate('Y-m-d H:i:s')]
        );
    }

    public function revokeAllSessions(int $userId): int
    {
        $stmt = Database::run(
            'UPDATE sessions SET revoked_at = ? WHERE user_id = ? AND revoked_at IS NULL',
            [gmdate('Y-m-d H:i:s'), $userId]
        );
        return $stmt->rowCount();
    }
}
