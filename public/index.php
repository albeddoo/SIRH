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
// Les modules fonctionnels arriveront en Phase 02+ (aucun bouton décoratif :
// chaque route ci-dessous est réellement implémentée).
$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/health', [\App\Controllers\HomeController::class, 'health']); // diagnostics socle (versions, BD, extensions)
$router->get('/csrf-token', static fn (): string => json_encode(['token' => Csrf::token()]));

$router->dispatch($method, $uri);
