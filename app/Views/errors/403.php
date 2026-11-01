<?php use App\Core\View; ?>
<div class="text-center py-5">
    <h1 class="h3">403 — Accès refusé</h1>
    <p class="text-muted">Votre compte ne dispose pas de la permission
        <code><?= View::e($permission ?? '') ?></code>.</p>
    <a class="btn btn-primary" href="javascript:history.back()">Retour</a>
</div>
