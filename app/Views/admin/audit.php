<?php

use App\Core\Url;
use App\Core\View;

?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Journal d'audit — <?= (int) $total ?> entrée(s)</h1>
    <form method="get" action="<?= Url::to('admin/audit') ?>" class="d-flex gap-2">
        <input class="form-control form-control-sm" name="action" placeholder="Filtrer l'action (ex. auth.)" value="<?= View::e($_GET['action'] ?? '') ?>">
        <input class="form-control form-control-sm" name="target" placeholder="Table cible" value="<?= View::e($_GET['target'] ?? '') ?>">
        <button type="submit" class="btn btn-sm btn-outline-primary">Filtrer</button>
    </form>
</div>

<div class="table-responsive card shadow-sm">
    <table class="table table-sm align-middle mb-0 small">
        <thead><tr><th>Date (UTC)</th><th>Utilisateur</th><th>Action</th><th>Cible</th><th>Détails</th><th>Résultat</th></tr></thead>
        <tbody>
        <?php foreach ($logs as $l): ?>
            <tr>
                <td class="text-nowrap"><?= View::e($l['created_at']) ?></td>
                <td><?= View::e($l['user_name'] ?? 'système') ?></td>
                <td><code><?= View::e($l['action']) ?></code></td>
                <td><?= View::e($l['target_table'] ?? '—') ?><?= $l['target_id'] !== null ? ' #' . View::e($l['target_id']) : '' ?></td>
                <td class="text-muted" style="max-width:320px;overflow:hidden;text-overflow:ellipsis"><?= View::e((string) ($l['new_values_json'] ?? '')) ?></td>
                <td><span class="badge bg-<?= $l['result'] === 'success' ? 'success' : ($l['result'] === 'blocked' ? 'warning text-dark' : 'danger') ?>"><?= View::e($l['result']) ?></span></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($logs === []): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Aucune entrée pour ce filtre.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pages > 1): ?>
<nav class="mt-3"><ul class="pagination pagination-sm justify-content-center">
    <?php for ($i = 1; $i <= min($pages, 20); $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="<?= Url::to('admin/audit') ?>?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor; ?>
</ul></nav>
<?php endif; ?>
