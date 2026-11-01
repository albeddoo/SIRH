<?php

declare(strict_types=1);

/**
 * SIRH — Helpers globaux légers (utilisés par les contrôleurs).
 * Chargé par bootstrap/app.php après l'autoloader.
 */

use App\Core\Flash;
use App\Core\Url;
use App\Core\View;
if (!function_exists('abort')) {
    /** Interrompt la requête avec un code HTTP et une page d'erreur simple. */
    function abort(int $code, string $message = ''): never
    {
        http_response_code($code);
        $tpl = $code === 404 ? 'errors/404' : 'errors/generic';
        try {
            echo View::render($tpl, ['code' => $code, 'message' => $message], null);
        } catch (\Throwable) {
            echo htmlspecialchars($message ?: ('Erreur ' . $code), ENT_QUOTES, 'UTF-8');
        }
        exit;
    }
}

if (!function_exists('redirect')) {
    /** Redirection vers une route interne via Url::to() (sous-dossier compatible). */
    function redirect(string $path): never
    {
        header('Location: ' . Url::to($path));
        exit;
    }
}

if (!function_exists('flash')) {
    /** Message flash de session (type: success|danger|warning|info). */
    function flash(string $type, string $message): void
    {
        Flash::set($type, $message);
    }
}
