<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Authentification + sessions révocables (Phase 02).
 * - Cookie de session "remember" = jeton aléatoire ; seul son SHA-256 est stocké en base (table sessions).
 * - Révocation immédiate possible côté BD (suppression/révocation de la ligne session).
 * - Verrouillage après N échecs (colonnes users.failed_login_count / locked_until, migration 0002).
 * - Hash bcrypt cost 11 (config security) — aucun mot de passe en clair, jamais.
 */
final class Auth
{
    private const REMEMBER_COOKIE = 'sirh_remember';
    /** @var array<string,mixed>|null Utilisateur courant en mémoire */
    private static ?array $user = null;
    private static bool $loaded = false;
    /** @var list<string>|null Permissions effectives (RBAC) */
    private static ?array $permissions = null;

    public static function attempt(string $email, string $password): bool
    {
        $u = Database::fetchOne('SELECT * FROM users WHERE email = ? LIMIT 1', [$email]);
        if ($u === null || !in_array($u['status'], ['active', 'pending'], true)) {
            // Compteur d'échec même pour e-mail inconnu côté vue : message générique.
            return false;
        }

        // Verrouillage temporaire (security.lockout_minutes paramétrable plus tard via settings).
        if ($u['locked_until'] !== null && strtotime((string) $u['locked_until']) > time()) {
            Flash::set('warning', 'Compte temporairement verrouillé. Réessayez plus tard.');
            Logger::warning('Connexion refusée (verrou)', ['user_id' => $u['id']]);
            return false;
        }

        if (!password_verify($password, $u['password_hash'])) {
            $attempts = (int) $u['failed_login_count'] + 1;
            $lock     = $attempts >= 5 ? gmdate('Y-m-d H:i:s', time() + 900) : null;
            Database::run(
                'UPDATE users SET failed_login_count = ?, locked_until = ? WHERE id = ?',
                [$attempts, $lock, $u['id']]
            );
            Logger::warning('Échec de connexion', ['email_domain' => substr(strrchr($email, '@') ?: '', 1)]);
            return false;
        }

        self::login($u);
        return true;
    }

    /** Ouvre la session applicative (rotation PHP + jeton révocable en base). */
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id']   = (int) $user['id'];
        $_SESSION['ip']        = $_SERVER['REMOTE_ADDR'] ?? 'cli';
        self::$user            = $user;
        self::$loaded          = true;
        self::$permissions     = null;

        Database::run('UPDATE users SET failed_login_count = 0, locked_until = NULL, last_login_at = ? WHERE id = ?', [gmdate('Y-m-d H:i:s'), $user['id']]);

        $token = bin2hex(random_bytes(32));
        Database::run(
            'INSERT INTO sessions (user_id, token_hash, ip_address, user_agent, last_activity_at, expires_at)
             VALUES (?, ?, ?, ?, ?, ?)',
            [(int) $user['id'], hash('sha256', $token), $_SERVER['REMOTE_ADDR'] ?? null,
             substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255), gmdate('Y-m-d H:i:s'),
             gmdate('Y-m-d H:i:s', time() + 7 * 86400)]
        );
        setcookie(self::REMEMBER_COOKIE, $token, [
            'path' => Url::basePath() ?: '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => false,
        ]);

        Audit::log('auth.login', 'users', (int) $user['id']);
    }

    /** Identifie l'utilisateur courant via session PHP puis cookie révocable. */
    public static function user(): ?array
    {
        if (self::$loaded) {
            return self::$user;
        }
        self::$loaded = true;

        $uid = $_SESSION['user_id'] ?? null;
        if ($uid === null) {
            $token = $_COOKIE[self::REMEMBER_COOKIE] ?? '';
            if (is_string($token) && strlen($token) === 64) {
                $row = Database::fetchOne(
                    'SELECT s.id AS sid, s.user_id, u.* FROM sessions s
                     JOIN users u ON u.id = s.user_id
                     WHERE s.token_hash = ? AND s.revoked_at IS NULL AND s.expires_at > ? LIMIT 1',
                    [hash('sha256', $token), gmdate('Y-m-d H:i:s')]
                );
                if ($row !== null) {
                    $uid = $row['user_id'];
                    $_SESSION['user_id'] = (int) $uid;
                    Database::run('UPDATE sessions SET last_activity_at = ? WHERE id = ?', [gmdate('Y-m-d H:i:s'), $row['sid']]);
                }
            }
        }
        if ($uid === null) {
            return self::$user = null;
        }

        $u = Database::fetchOne('SELECT * FROM users WHERE id = ? LIMIT 1', [$uid]);
        if ($u === null || $u['status'] !== 'active') {
            self::logout();
            return self::$user = null;
        }
        return self::$user = $u;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function id(): ?int
    {
        return self::check() ? (int) self::$user['id'] : null;
    }

    public static function logout(): void
    {
        $token = $_COOKIE[self::REMEMBER_COOKIE] ?? '';
        if (is_string($token) && strlen($token) === 64) {
            Database::run('UPDATE sessions SET revoked_at = ? WHERE token_hash = ? AND revoked_at IS NULL', [gmdate('Y-m-d H:i:s'), hash('sha256', $token)]);
        }
        setcookie(self::REMEMBER_COOKIE, '', time() - 3600, (Url::basePath() ?: '/'));
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
        self::$user = null;
        self::$loaded = true;
        self::$permissions = null;
    }

    /** ── RBAC ───────────────────────────────────────────────────────────────
     * Permissions = union des permissions des rôles de l'utilisateur (user_roles → role_permissions).
     * super_admin possède tout (seed 0007). Cache par requête.
     */
    public static function permissions(int $userId): array
    {
        if (self::$permissions !== null) {
            return self::$permissions;
        }
        $rows = Database::fetchAll(
            'SELECT DISTINCT p.code
             FROM user_roles ur
             JOIN role_permissions rp ON rp.role_id = ur.role_id
             JOIN permissions p ON p.id = rp.permission_id
             JOIN roles r ON r.id = ur.role_id AND r.archived_at IS NULL
             WHERE ur.user_id = ?',
            [$userId]
        );
        return self::$permissions = array_map(static fn ($r) => $r['code'], $rows);
    }

    public static function can(string $permission): bool
    {
        if (!self::check()) {
            return false;
        }
        return in_array($permission, self::permissions((int) self::$user['id']), true);
    }

    /** Garde de contrôleur : redirige vers /login si non connecté. */
    public static function requireLogin(): array
    {
        $u = self::user();
        if ($u === null) {
            Flash::set('warning', 'Connexion requise.');
            header('Location: ' . Url::to('login'));
            exit;
        }
        return $u;
    }

    /** Garde RBAC : 403 journalisé si permission manquante. */
    public static function requirePermission(string $permission): void
    {
        self::requireLogin();
        if (!self::can($permission)) {
            Logger::warning('Accès refusé (RBAC)', ['user_id' => self::id(), 'need' => $permission]);
            http_response_code(403);
            echo View::render('errors/403', ['permission' => $permission], null);
            exit;
        }
    }
}
