<?php

use App\Core\View;

?>
<h1 class="h4 mb-3">Rôles et permissions (<?= count($roles) ?> rôles)</h1>
<div class="table-responsive card shadow-sm">
    <table class="table table-bordered align-middle mb-0 small">
        <thead>
            <tr><th style="min-width:220px">Permission</th><?php foreach ($roles as $r): ?><th class="text-center"><?= View::e($r['code']) ?><br><span class="text-muted fw-normal"><?= (int) $r['nb_users'] ?> user(s)</span></th><?php endforeach; ?></tr>
        </thead>
        <tbody>
        <?php foreach ($permissions as $p): ?>
            <tr>
                <td><code><?= View::e($p['code']) ?></code><br><span class="text-muted"><?= View::e($p['description'] ?? '') ?></span></td>
                <?php foreach ($roles as $r): ?>
                    <td class="text-center"><?= in_array((int) $p['id'], $matrix[(int) $r['id']] ?? [], true) ? '✔' : '' ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="text-muted small mt-2">Matrice en lecture seule : l'affectation des permissions aux rôles système se fait par migration seed (traçabilité Git), conformément au registre documentaire. L'affectation des rôles aux utilisateurs se fait depuis la page Utilisateurs.</p>
