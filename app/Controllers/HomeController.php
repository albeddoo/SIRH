<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Migrator;

/**
 * Page d'accueil du socle + page /health (diagnostic réel de l'environnement).
 * Aucune donnée inventée : tout ce qui est affiché est mesuré.
 */
final class HomeController extends Controller
{
    public function index(): string
    {
        return $this->view('home/index', [
            'title' => 'SIRH — Socle technique (Phase 01)',
        ]);
    }

    /** Diagnostic technique honnête : versions PHP/BD réelles, extensions, migrations. */
    public function health(): string
    {
        $data = [
            'php_version'   => PHP_VERSION,
            'timezone'      => date_default_timezone_get(),
            'extensions'    => [],
            'database'      => ['status' => 'inconnu'],
            'migrations'    => ['status' => 'inconnu'],
        ];

        foreach (['pdo_mysql', 'mbstring', 'fileinfo', 'openssl', 'zip', 'gd', 'intl', 'session'] as $ext) {
            $data['extensions'][$ext] = extension_loaded($ext);
        }

        try {
            $row = Database::fetchOne('SELECT VERSION() AS v, @@collation_server AS coll');
            $data['database'] = [
                'status'    => 'connecté',
                'version'   => $row['v'] ?? '?',
                'collation' => $row['coll'] ?? '?',
            ];

            $cfg   = require dirname(__DIR__, 2) . '/config/config.php';
            $mig   = new Migrator(Database::pdo(), $cfg['paths']['migrations']);
            $mig->ensureTable();
            $st    = $mig->status();
            $data['migrations'] = [
                'status'    => 'ok',
                'current'   => $st['database'],
                'applied'   => count($st['applied']),
                'pending'   => count($st['pending']),
            ];
        } catch (\Throwable $e) {
            $data['database'] = ['status' => 'erreur', 'message' => $e->getMessage()];
        }

        return $this->view('home/health', ['title' => 'Diagnostic technique', 'diag' => $data], null);
    }
}
