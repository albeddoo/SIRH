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
 * Authentification (Phase 02) — connexion, déconnexion, profil, préférences.
 * Sessions révocables via table sessions (cookie jeton, hash SHA-256 en base).
 */
final class AuthController extends Controller
{
    public function showLogin(): string
    {
        if (Auth::check()) {
            $this->redirect('');
        }
        return $this->view('auth/login', ['title' => 'Connexion — SIRH']);
    }

    public function login(): string
    {
        Csrf::verifyOrDie();
        $v = Validator::make($_POST)->required('email', 'E-mail')->required('password', 'Mot de passe');
        if ($v->fails()) {
            Flash::set('danger', implode(' ', $v->firstErrors()));
            $this->redirect('login');
        }

        if (Auth::attempt(trim((string) $_POST['email']), (string) $_POST['password'])) {
            Flash::set('success', 'Bienvenue, ' . Auth::user()['first_name'] . '.');
            $this->redirect('');
        }

        // Message volontairement générique (pas d'énumération de comptes).
        Flash::set('danger', 'Identifiants incorrects ou compte non actif.');
        $this->redirect('login');
    }

    public function logout(): string
    {
        Csrf::verifyOrDie();
        Auth::logout();
        Flash::set('info', 'Déconnexion effectuée.');
        $this->redirect('login');
    }

    /** Profil + préférences personnelles (table user_preferences, migration 0002 ; format clé/valeur). */
    public function profile(): string
    {
        $u = Auth::requireLogin();
        $rows = Database::fetchAll('SELECT pref_key, pref_value FROM user_preferences WHERE user_id = ?', [$u['id']]);
        $prefs = [];
        foreach ($rows as $r) {
            $prefs[$r['pref_key']] = $r['pref_value'];
        }
        return $this->view('auth/profile', ['title' => 'Mon profil', 'user' => $u, 'prefs' => $prefs]);
    }

    public function savePreferences(): string
    {
        $u = Auth::requireLogin();
        Csrf::verifyOrDie();
        // Valeurs strictement encadrées (liste blanche) — aucune donnée libre en base.
        $theme   = in_array($_POST['theme'] ?? '', ['light', 'dark'], true) ? $_POST['theme'] : 'light';
        $density = in_array($_POST['density'] ?? '', ['comfortable', 'compact'], true) ? $_POST['density'] : 'comfortable';

        foreach (['theme' => $theme, 'density' => $density] as $key => $value) {
            Database::run(
                'INSERT INTO user_preferences (user_id, pref_key, pref_value) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE pref_value = VALUES(pref_value)',
                [$u['id'], $key, $value]
            );
        }
        Audit::log('preferences.update', 'user_preferences', (int) $u['id'], ['theme' => $theme, 'density' => $density]);
        Flash::set('success', 'Préférences enregistrées.');
        $this->redirect('profile');
    }

    /** Changement de mot de passe (le premier n'est jamais exposé ; bcrypt uniquement). */
    public function changePassword(): string
    {
        $u = Auth::requireLogin();
        Csrf::verifyOrDie();
        $v = Validator::make($_POST)
            ->required('current', 'Mot de passe actuel')
            ->required('new', 'Nouveau mot de passe')
            ->minLength('new', 8, 'Nouveau mot de passe');
        if ($v->fails()) {
            Flash::set('danger', implode(' ', $v->firstErrors()));
            $this->redirect('profile');
        }
        if (!password_verify((string) $_POST['current'], $u['password_hash'])) {
            Flash::set('danger', 'Mot de passe actuel incorrect.');
            $this->redirect('profile');
        }
        $hash = password_hash((string) $_POST['new'], PASSWORD_BCRYPT, ['cost' => 11]);
        Database::run('UPDATE users SET password_hash = ?, must_change_password = 0 WHERE id = ?', [$hash, $u['id']]);
        Audit::log('auth.password_change', 'users', (int) $u['id']);
        Flash::set('success', 'Mot de passe modifié.');
        $this->redirect('profile');
    }
}
