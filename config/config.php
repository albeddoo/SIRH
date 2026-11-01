<?php
/**
 * SIRH — Configuration applicative (Phase 01 : socle technique)
 *
 * Aucune valeur sensible en dur : les secrets proviennent de config/.env
 * (fichier hors Git, modèle fourni : config/.env.example).
 *
 * Compatibilité sous-dossier local WampServer : BASE_URL est dérivée
 * automatiquement du dossier d'installation (voir Core\Url), jamais codée en dur.
 */

declare(strict_types=1);

// ─── Chargement du fichier .env (local uniquement) ───────────────────────────
(function (): void {
    $envFile = dirname(__DIR__) . '/config/.env';
    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key = trim($key);
            $value = trim(trim($value), "\"'");
            if ($key !== '' && getenv($key) === false) {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
        }
    }
})();

/** Lit une variable d'environnement avec valeur par défaut. */
function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

return [
    // ── Application ──────────────────────────────────────────────────────────
    'app' => [
        'name'         => env('APP_NAME', 'SIRH'),
        'env'          => env('APP_ENV', 'local'),          // local uniquement (interdit Cloud)
        'debug'        => env('APP_DEBUG', 'true') === 'true',
        'timezone'     => env('APP_TIMEZONE', 'Africa/Casablanca'), // exigence MP §i18n / T-xx
        'locale'       => env('APP_LOCALE', 'fr'),
        // Stockage des dates en UTC en base ; affichage dans le fuseau ci-dessus.
        'db_store_utc' => true,
    ],

    // ── Base de données (PDO MySQL/MariaDB) ──────────────────────────────────
    'database' => [
        'driver'    => 'mysql',                    // pdo_mysql
        'host'      => env('DB_HOST', '127.0.0.1'),
        'port'      => (int) env('DB_PORT', '3306'), // port MySQL WampServer par défaut
        'database'  => env('DB_DATABASE', 'sirh'),
        'username'  => env('DB_USERNAME', 'root'),
        'password'  => env('DB_PASSWORD', ''),
        'charset'   => 'utf8mb4',
        // D-20 résolue sur la version réellement détectée (MariaDB 10.x → utf8mb4_unicode_ci,
        // collation compatible MySQL 8 comme MariaDB ; jamais 0900_ai_ci qui est MySQL-only).
        'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
        'options'   => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // exigence MP V3
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,                  // vraies requêtes préparées
        ],
    ],

    // ── Sessions & sécurité ──────────────────────────────────────────────────
    'security' => [
        'session_name'           => 'sirh_session',
        'session_lifetime_min'   => (int) env('SESSION_LIFETIME', '120'),
        'csrf_token_name'        => '_csrf',
        'password_algo'          => PASSWORD_BCRYPT, // argon2id dépend de la build PHP du poste (D-05)
        'password_options'       => ['cost' => 11],
        'max_login_attempts'     => 5,
        'lockout_seconds'        => 900,
    ],

    // ── Upload / documents (détail : Phase stockage, doc 09) ─────────────────
    'uploads' => [
        'max_size_mb'       => (int) env('UPLOAD_MAX_MB', '10'),
        'allowed_mime'      => ['application/pdf', 'image/jpeg', 'image/png'],
        'allowed_ext'       => ['pdf', 'jpg', 'jpeg', 'png'],
        'storage_path'      => dirname(__DIR__) . '/storage/documents', // JAMAIS sous public/
    ],

    // ── Chemins (aucun chemin absolu codé en dur ailleurs) ───────────────────
    'paths' => [
        'base'      => dirname(__DIR__),
        'app'       => dirname(__DIR__) . '/app',
        'views'     => dirname(__DIR__) . '/app/Views',
        'logs'      => dirname(__DIR__) . '/storage/logs',
        'cache'     => dirname(__DIR__) . '/storage/framework/cache',
        'documents' => dirname(__DIR__) . '/storage/documents',
        'migrations'=> dirname(__DIR__) . '/database/migrations',
    ],

    // ── Services externes IA : désactivés par défaut (D-07 / D-18 / D-10) ────
    'ai' => [
        'external_enabled' => false,
        'note'             => 'Aucune donnée candidate envoyée hors de la machine locale sans autorisation écrite (loi 09-08).',
    ],
];
