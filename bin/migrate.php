<?php

declare(strict_types=1);

use App\Core\Migrator;

/**
 * CLI : php bin/migrate.php [status|migrate]
 * Migrations forward-only reproductibles (D-21 résolue : script maison).
 */

if (PHP_SAPI !== 'cli') {
    exit("Ce script s'exécute uniquement en ligne de commande.\n");
}

$root = dirname(__DIR__);
require $root . '/bootstrap/autoload.php';
$config = require $root . '/config/config.php';

date_default_timezone_set($config['app']['timezone']);

$dsn = sprintf(
    'mysql:host=%s;port=%d;charset=utf8mb4',
    $config['database']['host'],
    $config['database']['port']
);

try {
    // Connexion sans nom de base pour permettre la création si absente.
    $pdo = new PDO($dsn, $config['database']['username'], $config['database']['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec(sprintf(
        'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE %s',
        str_replace('`', '', $config['database']['database']), // nom issu du .env local, jamais de l'entrée utilisateur
        $config['database']['collation']
    ));
    $pdo->exec('USE `' . str_replace('`', '', $config['database']['database']) . '`');
} catch (PDOException $e) {
    fwrite(STDERR, "Connexion impossible : {$e->getMessage()}\n");
    fwrite(STDERR, "Vérifiez que MySQL/MariaDB est démarré dans WampServer et config/.env.\n");
    exit(1);
}

$migrator = new Migrator($pdo, $config['paths']['migrations']);
$migrator->ensureTable();

$command = $argv[1] ?? 'status';

switch ($command) {
    case 'status':
        $st = $migrator->status();
        echo "Migration courante : " . ($st['database'] ?? '(aucune)') . "\n";
        echo "Appliquées (" . count($st['applied']) . ") :\n";
        foreach ($st['applied'] as $f) {
            echo "  ✔ {$f}\n";
        }
        echo "En attente (" . count($st['pending']) . ") :\n";
        foreach ($st['pending'] as $f) {
            echo "  ⏳ {$f}\n";
        }
        break;

    case 'migrate':
        $count = $migrator->migrate(static fn (string $m) => print($m . "\n"));
        echo $count === 0
            ? "Aucune migration en attente. Base à jour.\n"
            : "{$count} migration(s) appliquée(s).\n";
        break;

    default:
        echo "Usage : php bin/migrate.php [status|migrate]\n";
        exit(1);
}
