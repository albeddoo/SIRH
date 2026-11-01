<?php
/** Page de diagnostic : affiche des MESURES réelles, jamais des valeurs inventées. */
use App\Core\View;
$ok = static fn (bool $b): string => $b ? '<span class="badge text-bg-success">OK</span>' : '<span class="badge text-bg-danger">MANQUANT</span>';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= View::e($title) ?></title>
    <link rel="stylesheet" href="<?= \App\Core\Url::asset('vendor/bootstrap/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= \App\Core\Url::asset('css/app.css') ?>">
</head>
<body class="container py-4">
<h1 class="h4 mb-3">Diagnostic technique réel — <?= View::e($diag['php_version']) ? 'PHP ' . View::e($diag['php_version']) : '' ?></h1>
<table class="table table-bordered table-sm bg-white">
    <tr><th>Fuseau applicatif</th><td><?= View::e($diag['timezone']) ?> (base stockée en UTC)</td></tr>
    <tr><th>Base de données</th>
        <td>
            <?= $ok(($diag['database']['status'] ?? '') === 'connecté') ?>
            <?= isset($diag['database']['version']) ? View::e($diag['database']['version']) : '' ?>
            <?= isset($diag['database']['collation']) ? ' · collation serveur ' . View::e($diag['database']['collation']) : '' ?>
            <?= isset($diag['database']['message']) ? ' — ' . View::e($diag['database']['message']) : '' ?>
        </td></tr>
    <tr><th>Migrations</th>
        <td>
            <?= $ok(($diag['migrations']['status'] ?? '') === 'ok') ?>
            version courante : <?= View::e($diag['migrations']['current'] ?? '(aucune)') ?> ·
            appliquées : <?= (int) ($diag['migrations']['applied'] ?? 0) ?> ·
            en attente : <?= (int) ($diag['migrations']['pending'] ?? 0) ?>
        </td></tr>
    <tr><th>Extensions PHP requises</th>
        <td><?php foreach ($diag['extensions'] as $ext => $loaded): ?>
                <span class="me-2"><?= View::e($ext) ?> <?= $ok((bool) $loaded) ?></span>
            <?php endforeach; ?></td></tr>
</table>
<a class="btn btn-outline-primary btn-sm" href="<?= \App\Core\Url::to('') ?>">← Accueil</a>
<script src="<?= \App\Core\Url::asset('js/app.js') ?>"></script>
</body>
</html>
