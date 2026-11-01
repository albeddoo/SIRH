<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base des contrôleurs — helpers de réponse.
 */
abstract class Controller
{
    protected function view(string $template, array $data = [], ?string $layout = 'layouts/main'): string
    {
        return View::render($template, $data, $layout);
    }

    /** Redirection vers une route interne (aucun redirect codé en dur). */
    protected function redirect(string $path): never
    {
        header('Location: ' . Url::to($path));
        exit;
    }

    protected function json(mixed $payload, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($payload, JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    protected function notFound(): string
    {
        http_response_code(404);
        return View::render('errors/404', [], null);
    }

    /** Garde RBAC (Auth::requirePermission coupe-court avec 403 journalisé). */
    protected function requirePermission(string $permission): void
    {
        Auth::requirePermission($permission);
    }

    /** Vérification CSRF explicite dans les contrôleurs. */
    protected function verifyCsrf(): void
    {
        Csrf::verifyOrDie();
    }

    /** POST obligatoire + CSRF pour les actions en mutation. */
    protected function verifyCsrfPost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            exit('Méthode non autorisée.');
        }
        $this->verifyCsrf();
    }
}
