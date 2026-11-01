<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\{Auth, Controller, Csrf, Flash, Settings};
use App\Models\{Job, PipelineStage};

/**
 * M4 — Gestion des offres (MP §5.2, docs 06 M4).
 * Toutes les actions sont protégées par permission RBAC réelle (T-30).
 */
final class JobController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('job.view');
        $q = trim((string)($_GET['q'] ?? ''));
        $status = (string)($_GET['status'] ?? '');
        $page = max(1, (int)($_GET['p'] ?? 1));
        $perPage = (int) Settings::get('jobs_per_page', 15);
        [$items, $total] = Job::search($q, $status, $page, $perPage);
        $this->view('jobs/index', [
            'title' => 'Offres d\'emploi',
            'items' => $items, 'total' => $total, 'page' => $page,
            'pages' => max(1, (int)ceil($total / $perPage)),
            'q' => $q, 'status' => $status,
        ]);
    }

    public function show(int $id): void
    {
        $this->requirePermission('job.view');
        $job = Job::findWithRefs($id);
        if (!$job) { abort(404, 'Offre introuvable.'); }
        $this->view('jobs/show', ['title' => 'Offre '.$job['reference'], 'job' => $job,
            'applications' => Job::applicationsSummary($id)]);
    }

    public function create(): void
    {
        $this->requirePermission('job.create');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
            $data = $this->collectAndValidate();
            if (!empty($data['_errors'])) {
                Flash::error('Formulaire incomplet : '.implode(' | ', $data['_errors']));
                $this->renderForm($data, null);
                return;
            }
            $id = Job::create($data, Auth::id());
            \App\Core\Audit::log('job.create', 'jobs', $id, null, $data);
            Flash::success('Offre créée (référence '.$data['reference'].').');
            redirect('/jobs/'.$id);
        }
        $this->renderForm([], null);
    }

    public function edit(int $id): void
    {
        $this->requirePermission('job.update');
        $job = Job::find($id);
        if (!$job) { abort(404, 'Offre introuvable.'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
            $data = $this->collectAndValidate($id);
            if (!empty($data['_errors'])) {
                Flash::error('Formulaire incomplet : '.implode(' | ', $data['_errors']));
                $this->renderForm($data, $job);
                return;
            }
            Job::update($id, $data);
            \App\Core\Audit::log('job.update', 'jobs', $id, $job, $data);
            Flash::success('Offre mise à jour.');
            redirect('/jobs/'.$id);
        }
        $this->renderForm($job, $job);
    }

    public function validatePublish(int $id): void
    {
        $this->requirePermission('job.validate');
        $this->verifyCsrfPost();
        $job = Job::find($id);
        if (!$job) { abort(404); }
        if ($job['status'] !== 'draft') { Flash::warning('Seule une offre en brouillon peut être validée.'); redirect('/jobs/'.$id); }
        Job::setStatus($id, 'open');
        \App\Core\Audit::log('job.validate', 'jobs', $id, ['status'=>$job['status']], ['status'=>'open']);
        Flash::success('Offre validée et publiée.');
        redirect('/jobs/'.$id);
    }

    public function archive(int $id): void
    {
        $this->requirePermission('job.archive');
        $this->verifyCsrfPost();
        $job = Job::find($id);
        if (!$job) { abort(404); }
        Job::archive($id);
        \App\Core\Audit::log('job.archive', 'jobs', $id, null, ['archived'=>true]);
        Flash::success('Offre archivée.');
        redirect('/jobs');
    }

    private function verifyCsrfPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { abort(405, 'Méthode non autorisée.'); }
        $this->verifyCsrf();
    }

    /** @return array<string,mixed> */
    private function collectAndValidate(?int $excludeId = null): array
    {
        $in = [
            'reference' => trim((string)($_POST['reference'] ?? '')),
            'title' => trim((string)($_POST['title'] ?? '')),
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'job_family_id' => (int)($_POST['job_family_id'] ?? 0),
            'city_id' => (int)($_POST['city_id'] ?? 0),
            'contract_type_id' => (int)($_POST['contract_type_id'] ?? 0),
            'work_time_type_id' => (int)($_POST['work_time_type_id'] ?? 0),
            'nb_positions' => (int)($_POST['nb_positions'] ?? 1),
            'experience_min_months' => (int)($_POST['experience_min_months'] ?? 0),
            'summary' => trim((string)($_POST['summary'] ?? '')),
            'missions' => trim((string)($_POST['missions'] ?? '')),
            'context' => trim((string)($_POST['context'] ?? '')),
            'benefits' => trim((string)($_POST['benefits'] ?? '')),
            'published_at' => trim((string)($_POST['published_at'] ?? '')),
            'closing_at' => trim((string)($_POST['closing_at'] ?? '')),
        ];
        $v = \App\Core\Validator::make($in, [
            'reference' => 'required|max:30|unique:jobs,reference,'.(int)$excludeId,
            'title' => 'required|max:180',
            'department_id' => 'required|int|min:1',
            'city_id' => 'required|int|min:1',
            'contract_type_id' => 'required|int|min:1',
            'nb_positions' => 'required|int|min:1|max:999',
            'summary' => 'required|max:2000',
        ]);
        $in['_errors'] = $v->errors();
        return $in;
    }

    private function renderForm(array $d, ?array $job): void
    {
        $this->view('jobs/form', ['title' => $job ? 'Modifier l\'offre' : 'Nouvelle offre',
            'd' => $d, 'job' => $job,
            'departments' => \App\Core\Database::run('SELECT id,name FROM departments WHERE archived_at IS NULL ORDER BY name')->fetchAll(),
            'families' => \App\Core\Database::run('SELECT id,label FROM job_families WHERE archived_at IS NULL ORDER BY label')->fetchAll(),
            'cities' => \App\Core\Database::run('SELECT id,name FROM cities WHERE archived_at IS NULL ORDER BY name LIMIT 200')->fetchAll(),
            'contracts' => \App\Core\Database::run('SELECT id,label FROM contract_types WHERE archived_at IS NULL ORDER BY label')->fetchAll(),
            'worktimes' => \App\Core\Database::run('SELECT id,label FROM work_time_types WHERE archived_at IS NULL ORDER BY label')->fetchAll(),
        ]);
    }
}
