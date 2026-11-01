<?php
/**
 * SIRH — Autoloader PSR-4 simplifié (namespace App\ → app/)
 * MVC personnalisé, sans dépendance Composer obligatoire (Phase 01).
 */

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefix  = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    if (!str_starts_with($class, $prefix)) {
        return; // classes globales / autres namespaces
    }

    $relative = substr($class, strlen($prefix));
    $file     = $baseDir . str_replace('\\', '/', $relative) . '.php';

    if (is_file($file)) {
        require $file;
    }
});
