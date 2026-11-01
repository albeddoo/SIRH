<?php

declare(strict_types=1);

/**
 * SIRH — Front Controller unique (tout passe par ici, DocumentRoot = public/).
 * En-têtes de sécurité applicatifs (durcissement Apache : .htaccess + T-35).
 */

$config = require dirname(__DIR__) . '/bootstrap/app.php';

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Router;
use App\Core\Url;

Logger::init($config['paths']['logs']);
Database::configure($config['database']);

// ── En-têtes de sécurité (local HTTP) ────────────────────────────────────────
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self'; img-src 'self' data:");

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri    = $_SERVER['REQUEST_URI'] ?? '/';

$router = new Router();

// ── Routes du socle (Phase 01) ───────────────────────────────────────────────
$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/health', [\App\Controllers\HomeController::class, 'health']); // diagnostics socle (versions, BD, extensions)
$router->get('/csrf-token', static fn (): string => json_encode(['token' => Csrf::token()]));

// ── Authentification & sessions révocables (Phase 02) ───────────────────────
$AC = \App\Controllers\AuthController::class;
$router->get('/login',  [$AC, 'showLogin']);
$router->post('/login', [$AC, 'login']);
$router->post('/logout', [$AC, 'logout']);
$router->get('/profile', [$AC, 'profile']);
$router->post('/profile/preferences', [$AC, 'savePreferences']);
$router->post('/profile/password', [$AC, 'changePassword']);

// ── Administration : utilisateurs, rôles, paramètres, audit (Phase 02) ──────
$AD = \App\Controllers\AdminController::class;
$router->get('/admin/users', [$AD, 'users']);
$router->post('/admin/users/create', [$AD, 'createUser']);
$router->post('/admin/users/{id}/toggle', [$AD, 'toggleUserStatus']);
$router->post('/admin/users/{id}/roles', [$AD, 'saveUserRoles']);
$router->get('/admin/roles', [$AD, 'roles']);
$router->get('/admin/settings', [$AD, 'settings']);
$router->post('/admin/settings/save', [$AD, 'saveSetting']);
$router->get('/admin/audit', [\App\Controllers\AuditController::class, 'index']);

$router->dispatch($method, $uri);
