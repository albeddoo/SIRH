<?php
/**
 * SIRH — Amorçage de l'application (Phase 01 socle)
 * Fuseau horaire, erreurs, sessions sécurisées.
 */

declare(strict_types=1);

$root = dirname(__DIR__);

require $root . '/bootstrap/autoload.php';
require $root . '/bootstrap/helpers.php'; // abort(), redirect(), flash()

$config = require $root . '/config/config.php';

// ── Fuseau : stockage UTC en base, affichage Africa/Casablanca (MP i18n) ─────
date_default_timezone_set($config['app']['timezone']);

// ── Gestion des erreurs : jamais de stack trace exposée hors debug local ─────
error_reporting(E_ALL);
ini_set('display_errors', $config['app']['debug'] ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', $config['paths']['logs'] . '/app.log');

set_exception_handler(static function (\Throwable $e) use ($config): void {
    \App\Core\Logger::error('Uncaught: ' . $e->getMessage(), [
        'file' => $e->getFile(), 'line' => $e->getLine(),
    ]);
    http_response_code(500);
    if ($config['app']['debug']) {
        echo '<h1>Erreur 500</h1><pre>' . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        echo '<h1>Erreur interne du serveur</h1><p>Une erreur est survenue. Consultez storage/logs/app.log.</p>';
    }
});

set_error_handler(static function (int $severity, string $message, string $file = '', int $line = 0): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

register_shutdown_function(static function () use ($config): void {
    $err = error_get_last();
    if ($err !== null && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        \App\Core\Logger::error('Fatal: ' . $err['message'], ['file' => $err['file'], 'line' => $err['line']]);
    }
});

// ── Session sécurisée (cookie HttpOnly, SameSite=Lax, local only) ────────────
if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE) {
    session_name($config['security']['session_name']);
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => \App\Core\Url::basePath(),
        'domain'   => '',
        'secure'   => false, // localhost HTTP ; à passer true si HTTPS local configuré
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

return $config;
