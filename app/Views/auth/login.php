<?php

use App\Core\Csrf;
use App\Core\Url;

?>
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 card-title mb-3">Connexion SIRH</h1>
                <form method="post" action="<?= Url::to('login') ?>" novalidate>
                    <?= Csrf::field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="email">E-mail</label>
                        <input class="form-control" type="email" id="email" name="email" required autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input class="form-control" type="password" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
                <p class="text-muted small mt-3 mb-0">Comptes créés par l'administrateur. Les tentatives répétées verrouillent temporairement le compte.</p>
            </div>
        </div>
    </div>
</div>
