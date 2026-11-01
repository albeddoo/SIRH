<?php
/** Layout principal Bootstrap 5 — responsive (exigence T-32). */
use App\Core\Url;
use App\Core\View;
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= View::e($title ?? 'SIRH') ?></title>
    <!-- Bootstrap 5 : en production locale, placer les fichiers dans public/assets/vendor/bootstrap/
         (auto-hébergement obligatoire — aucune dépendance Internet, cf. D-17/T-31).
         fallback CSS local minimal : assets/css/app.css -->
    <link rel="stylesheet" href="<?= Url::asset('vendor/bootstrap/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= Url::asset('css/app.css') ?>">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= Url::to('') ?>">SIRH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= Url::to('') ?>">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= Url::to('health') ?>">Diagnostic</a></li>
                <!-- Les entrées modules n'apparaîtront qu'une fois leurs écrans réellement développés (Phase 02+). -->
            </ul>
        </div>
    </div>
</nav>
<main class="container pb-5">
    <?php foreach (($flashes ?? []) as $f): ?>
        <div class="alert alert-<?= View::e($f['type']) ?>"><?= View::e($f['message']) ?></div>
    <?php endforeach; ?>
    <?= $content ?>
</main>
<footer class="text-center text-muted small py-3">SIRH — application locale (WampServer), aucune donnée envoyée sur Internet.</footer>
<script src="<?= Url::asset('vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= Url::asset('js/app.js') ?>"></script>
</body>
</html>
