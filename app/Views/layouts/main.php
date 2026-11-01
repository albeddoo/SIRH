<?php

declare(strict_types=1);

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Url;
use App\Core\View;

/** Layout principal Bootstrap 5 — responsive (exigence T-32). */
$currentUser = Auth::user();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= View::e($title ?? 'SIRH') ?></title>
    <!-- Bootstrap 5 auto-hébergé (D-17/T-31 : aucune dépendance Internet) -->
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
                <?php if ($currentUser === null): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= Url::to('login') ?>">Connexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= Url::to('') ?>">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= Url::to('health') ?>">Diagnostic</a></li>
                    <?php /* Les entrées modules n'apparaissent qu'une fois leurs écrans réellement développés. */ ?>
                    <?php if (Auth::can('user.manage')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to('admin/users') ?>">Utilisateurs</a></li>
                    <?php endif; ?>
                    <?php if (Auth::can('role.manage')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to('admin/roles') ?>">Rôles</a></li>
                    <?php endif; ?>
                    <?php if (Auth::can('settings.manage')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to('admin/settings') ?>">Paramètres</a></li>
                    <?php endif; ?>
                    <?php if (Auth::can('audit.view')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to('admin/audit') ?>">Audit</a></li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><?= View::e($currentUser['first_name']) ?></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= Url::to('profile') ?>">Mon profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="post" action="<?= Url::to('logout') ?>" class="px-2">
                                    <?= Csrf::field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
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
