<?php

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Url;
use App\Core\View;

$badge = ['active' => 'success', 'pending' => 'warning', 'suspended' => 'secondary', 'disabled' => 'danger', 'invite' => 'info'];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Utilisateurs (<?= count($users) ?>)</h1>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newUser">+ Nouvel utilisateur</button>
</div>

<div class="table-responsive card shadow-sm mb-4">
    <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Nom</th><th>E-mail</th><th>Rôles</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= View::e($u['last_name']) ?> <?= View::e($u['first_name']) ?></td>
                <td><?= View::e($u['email']) ?></td>
                <td class="small"><?= View::e(implode(', ', $u['role_names']) ?: '—') ?></td>
                <td><span class="badge bg-<?= $badge[$u['status']] ?? 'light text-dark' ?>"><?= View::e($u['status']) ?></span></td>
                <td class="text-nowrap">
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#roles<?= (int) $u['id'] ?>">Rôles</button>
                    <?php if ((int) $u['id'] !== Auth::id()): ?>
                        <form method="post" action="<?= Url::to('admin/users/' . (int) $u['id'] . '/toggle') ?>" class="d-inline">
                            <?= Csrf::field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-<?= $u['status'] === 'suspended' ? 'success' : 'danger' ?>">
                                <?= $u['status'] === 'suspended' ? 'Réactiver' : 'Suspendre' ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <div class="modal fade" id="roles<?= (int) $u['id'] ?>" tabindex="-1">
                <div class="modal-dialog"><div class="modal-content">
                    <form method="post" action="<?= Url::to('admin/users/' . (int) $u['id'] . '/roles') ?>">
                        <?= Csrf::field() ?>
                        <div class="modal-header"><h2 class="modal-title h6">Rôles — <?= View::e($u['email']) ?></h2></div>
                        <div class="modal-body">
                            <?php foreach ($allRoles as $r): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="role_ids[]" value="<?= (int) $r['id'] ?>"
                                           id="r<?= (int) $u['id'] ?>_<?= (int) $r['id'] ?>"
                                           <?= in_array((int) $r['id'], $uRoleMap[(int) $u['id']] ?? [], true) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="r<?= (int) $u['id'] ?>_<?= (int) $r['id'] ?>">
                                        <?= View::e($r['name']) ?> <span class="text-muted">(<?= View::e($r['code']) ?>)</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div></div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="newUser" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="post" action="<?= Url::to('admin/users/create') ?>">
            <?= Csrf::field() ?>
            <div class="modal-header"><h2 class="modal-title h6">Nouvel utilisateur</h2></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label" for="u_email">E-mail</label><input class="form-control" type="email" id="u_email" name="email" required></div>
                <div class="row"><div class="col"><div class="mb-2"><label class="form-label" for="u_fn">Prénom</label><input class="form-control" id="u_fn" name="first_name" required></div></div>
                <div class="col"><div class="mb-2"><label class="form-label" for="u_ln">Nom</label><input class="form-control" id="u_ln" name="last_name" required></div></div></div>
                <div class="mb-2"><label class="form-label" for="u_job">Fonction</label><input class="form-control" id="u_job" name="job_title"></div>
                <div class="mb-2"><label class="form-label" for="u_pw">Mot de passe initial (8 caractères min.)</label><input class="form-control" type="password" id="u_pw" name="password" minlength="8" required></div>
                <p class="text-muted small mb-0">Le changement de mot de passe sera imposé à la première connexion.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div></div>
</div>
