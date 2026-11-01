<?php

use App\Core\Csrf;
use App\Core\Url;
use App\Core\View;

?>
<h1 class="h4 mb-3">Paramètres globaux (<?= count($settings) ?>)</h1>
<div class="table-responsive card shadow-sm">
    <table class="table align-middle mb-0 small">
        <thead><tr><th>Clé</th><th>Valeur</th><th>Description</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($settings as $s): ?>
            <tr>
                <td><code><?= View::e($s['setting_key']) ?></code></td>
                <td>
                    <?php if ((int) $s['is_sensitive'] === 1): ?>
                        <span class="text-muted">protégé — non modifiable ici</span>
                    <?php else: ?>
                        <?= View::e($s['value_text'] ?? '—') ?> <span class="badge bg-light text-dark"><?= View::e($s['value_type']) ?></span>
                    <?php endif; ?>
                </td>
                <td class="text-muted"><?= View::e($s['description'] ?? '') ?></td>
                <td class="text-end">
                    <?php if ((int) $s['is_sensitive'] !== 1): ?>
                        <form method="post" action="<?= Url::to('admin/settings/save') ?>" class="d-flex gap-1 justify-content-end">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="setting_key" value="<?= View::e($s['setting_key']) ?>">
                            <input class="form-control form-control-sm" style="max-width:180px" name="value" value="<?= View::e($s['value_text'] ?? '') ?>" aria-label="Nouvelle valeur">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Enregistrer</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="text-muted small mt-2">Chaque modification est versionnée (historique setting_versions) et journalisée dans l'audit.</p>
