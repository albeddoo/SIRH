<?php
use App\Core\View;
?>
<div class="p-5 bg-white border rounded">
    <h1 class="h3">SIRH — Socle technique Phase 01</h1>
    <p class="text-muted">
        Application de gestion RH et de recrutement, exécutée <strong>exclusivement en local</strong>
        (WampServer). Aucune fonction principale ne nécessite Internet.
    </p>
    <hr>
    <p>Cette page atteste du fonctionnement du socle MVC :</p>
    <ul>
        <li>Front Controller + routage personnalisés ;</li>
        <li>connexion PDO MySQL/MariaDB ;</li>
        <li>sessions sécurisées + protection CSRF ;</li>
        <li>migrations SQL reproductibles.</li>
    </ul>
    <a class="btn btn-primary" href="<?= \App\Core\Url::to('health') ?>">Voir le diagnostic technique réel</a>
    <p class="text-muted small mt-3 mb-0">Les modules fonctionnels (Offres, Candidats, Pipeline, Administration…) seront livrés aux Phases 02 à 09 — aucun lien décoratif n'est affiché avant son développement réel.</p>
</div>
