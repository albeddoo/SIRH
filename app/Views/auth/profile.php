<?php

use App\Core\Csrf;
use App\Core\Url;
use App\Core\View;

?>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h5 card-title">Mon profil</h1>
                <table class="table table-sm mb-0">
                    <tr><th>Nom</th><td><?= View::e($user['last_name']) ?> <?= View::e($user['first_name']) ?></td></tr>
                    <tr><th>E-mail</th><td><?= View::e($user['email']) ?></td></tr>
                    <tr><th>Fonction</th><td><?= View::e($user['job_title'] ?? '—') ?></td></tr>
                    <tr><th>Dernière connexion</th><td><?= View::e($user['last_login_at'] ?? '—') ?> (UTC)</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 card-title">Préférences personnelles</h2>
                <form method="post" action="<?= Url::to('profile/preferences') ?>">
                    <?= Csrf::field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="theme">Thème</label>
                        <select class="form-select" id="theme" name="theme">
                            <option value="light" <?= ($prefs['theme'] ?? 'light') === 'light' ? 'selected' : '' ?>>Clair</option>
                            <option value="dark" <?= ($prefs['theme'] ?? '') === 'dark' ? 'selected' : '' ?>>Sombre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="density">Densité d'affichage</label>
                        <select class="form-select" id="density" name="density">
                            <option value="comfortable" <?= ($prefs['density'] ?? 'comfortable') === 'comfortable' ? 'selected' : '' ?>>Confortable</option>
                            <option value="compact" <?= ($prefs['density'] ?? '') === 'compact' ? 'selected' : '' ?>>Compacte</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 card-title">Changer mon mot de passe</h2>
                <form method="post" action="<?= Url::to('profile/password') ?>">
                    <?= Csrf::field() ?>
                    <div class="mb-2">
                        <label class="form-label" for="current">Mot de passe actuel</label>
                        <input class="form-control" type="password" id="current" name="current" required autocomplete="current-password">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="new">Nouveau mot de passe (8 caractères minimum)</label>
                        <input class="form-control" type="password" id="new" name="new" minlength="8" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
