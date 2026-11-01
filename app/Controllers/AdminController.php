<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Audit;
use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Validator;
use App\Models\User;

/**
 * Administration — utilisateurs, rôles/permissions, paramètres (MP §24.1→24.19).
 * Chaque action exige la permission RBAC correspondante (T-30 : permissions différentes démo/admin).
 */
final class AdminController extends Controller
{
    public function users(): string
    {
        Auth::requirePermission('user.manage');
        $users = (new User())->listWithRoles();
        $allRoles = Database::fetchAll('SELECT id, code, name FROM roles WHERE archived_at IS NULL ORDER BY code');
        $uRoleMap = [];
        foreach (Database::fetchAll('SELECT user_id, role_id FROM user_roles') as $row) {
            $uRoleMap[(int) $row['user_id']][] = (int) $row['role_id'];
        }
        return $this->view('admin/users', [
            'title' => 'Utilisateurs', 'users' => $users,
            'allRoles' => $allRoles, 'uRoleMap' => $uRoleMap,
        ]);
    }

    public function createUser(): string
    {
        Auth::requirePermission('user.manage');
        Csrf::verifyOrDie();
        $v = Validator::make($_POST)
            ->required('email', 'E-mail')->email('email')
            ->required('first_name', 'Prénom')->required('last_name', 'Nom')
            ->required('password', 'Mot de passe')->minLength('password', 8, 'Mot de passe');
        if ($v->fails()) {
            Flash::set('danger', implode(' ', $v->firstErrors()));
            $this->redirect('admin/users');
        }
        $model = new User();
        if ($model->findByEmail(trim((string) $_POST['email'])) !== null) {
            Flash::set('danger', 'Un compte existe déjà avec cet e-mail.');
            $this->redirect('admin/users');
        }
        $id = $model->insert([
            'email'         => mb_strtolower(trim((string) $_POST['email'])),
            'password_hash' => password_hash((string) $_POST['password'], PASSWORD_BCRYPT, ['cost' => 11]),
            'first_name'    => trim((string) $_POST['first_name']),
            'last_name'     => trim((string) $_POST['last_name']),
            'job_title'     => ($_POST['job_title'] ?? '') !== '' ? trim((string) $_POST['job_title']) : null,
            'status'        => 'active',
            'must_change_password' => 1, // premier mot de passe choisi par l'admin → changement imposé
            'created_by'    => Auth::id(),
        ]);
        Audit::log('user.create', 'users', $id, ['email_domain' => substr(strrchr($_POST['email'], '@') ?: '', 1)]);
        Flash::set('success', 'Utilisateur créé (changement de mot de passe imposé à la première connexion).');
        $this->redirect('admin/users');
    }

    public function toggleUserStatus(int $id): string
    {
        Auth::requirePermission('user.manage');
        Csrf::verifyOrDie();
        if ($id === Auth::id()) {
            Flash::set('warning', 'Vous ne pouvez pas suspendre votre propre compte.');
            $this->redirect('admin/users');
        }
        $u = (new User())->find($id);
        if ($u === null) {
            return $this->notFound();
        }
        $new = $u['status'] === 'suspended' ? 'active' : 'suspended';
        Database::run('UPDATE users SET status = ? WHERE id = ?', [$new, $id]);
        if ($new === 'suspended') {
            (new User())->revokeAllSessions($id); // session coupée immédiatement
        }
        Audit::log('user.status', 'users', $id, ['from' => $u['status'], 'to' => $new]);
        Flash::set('success', "Compte passé à « {$new} ».");
        $this->redirect('admin/users');
    }

    public function roles(): string
    {
        Auth::requirePermission('role.manage');
        $roles = Database::fetchAll(
            'SELECT r.*, COUNT(DISTINCT ur.user_id) AS nb_users, COUNT(rp.permission_id) AS nb_perms
             FROM roles r
             LEFT JOIN user_roles ur ON ur.role_id = r.id
             LEFT JOIN role_permissions rp ON rp.role_id = r.id
             WHERE r.archived_at IS NULL
             GROUP BY r.id ORDER BY r.code'
        );
        $permissions = Database::fetchAll('SELECT id, code, module, description FROM permissions ORDER BY module, code');
        $matrix = [];
        foreach (Database::fetchAll('SELECT role_id, permission_id FROM role_permissions') as $row) {
            $matrix[$row['role_id']][] = (int) $row['permission_id'];
        }
        return $this->view('admin/roles', [
            'title' => 'Rôles et permissions', 'roles' => $roles,
            'permissions' => $permissions, 'matrix' => $matrix,
        ]);
    }

    /** Affectation des rôles d'un utilisateur. */
    public function saveUserRoles(int $id): string
    {
        Auth::requirePermission('role.manage');
        Csrf::verifyOrDie();
        $roleIds = array_filter(array_map('intval', (array) ($_POST['role_ids'] ?? [])));
        $all = Database::fetchAll('SELECT id FROM roles WHERE archived_at IS NULL');
        $valid = array_column($all, 'id');
        $roleIds = array_values(array_intersect($roleIds, $valid)); // liste blanche : aucun id arbitraire

        Database::run('DELETE FROM user_roles WHERE user_id = ?', [$id]);
        foreach ($roleIds as $rid) {
            (new User())->attachRole($id, (int) $rid, Auth::id());
        }
        Audit::log('user.roles', 'users', $id, ['role_ids' => $roleIds]);
        Flash::set('success', 'Rôles enregistrés.');
        $this->redirect('admin/users');
    }

    public function settings(): string
    {
        Auth::requirePermission('settings.manage');
        $rows = Database::fetchAll('SELECT * FROM settings ORDER BY setting_key');
        return $this->view('admin/settings', ['title' => 'Paramètres globaux', 'settings' => $rows]);
    }

    public function saveSetting(): string
    {
        Auth::requirePermission('settings.manage');
        Csrf::verifyOrDie();
        $key = trim((string) ($_POST['setting_key'] ?? ''));
        $value = (string) ($_POST['value'] ?? '');
        $row = Database::fetchOne('SELECT * FROM settings WHERE setting_key = ? LIMIT 1', [$key]);
        if ($row === null || $row['is_sensitive'] === 1) {
            Flash::set('danger', 'Paramètre inconnu ou sensible (non modifiable ici).');
            $this->redirect('admin/settings');
        }
        // Versionnage avant modification (table setting_versions, migration 0003).
        Database::run(
            'INSERT INTO setting_versions (setting_id, old_value, new_value, changed_by) VALUES (?, ?, ?, ?)',
            [$row['id'], $row['value_text'], $value, Auth::id()]
        );
        Database::run('UPDATE settings SET value_text = ? WHERE id = ?', [$value, $row['id']]);
        Audit::log('settings.update', 'settings', (int) $row['id'], ['key' => $key, 'from' => $row['value_text'], 'to' => $value]);
        Flash::set('success', "Paramètre « {$key} » mis à jour (version historique conservée).");
        $this->redirect('admin/settings');
    }
}
