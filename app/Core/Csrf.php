<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Protection CSRF — jeton par session, vérification en temps constant.
 * (Prérequis des tests T-21→T-35 ; formulaires Phase 02+.)
 */
final class Csrf
{
    public static function token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /** Champ caché prêt à insérer dans un formulaire. */
    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    /** Valide le jeton reçu (POST ou en-tête X-CSRF-Token pour l'AJAX). */
    public static function check(?string $token = null): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $token ??= ($_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        $stored  = $_SESSION['_csrf_token'] ?? '';

        return is_string($token) && $token !== '' && $stored !== '' && hash_equals($stored, $token);
    }

    /** Coupe-court en cas de jeton invalide. */
    public static function verifyOrDie(): void
    {
        if (!self::check()) {
            http_response_code(419);
            Logger::warning('CSRF rejected', ['uri' => $_SERVER['REQUEST_URI'] ?? 'cli']);
            exit('Jeton de sécurité invalide. Rechargez la page et réessayez.');
        }
    }
}
