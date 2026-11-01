<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Audit;
use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;

/**
 * Journal d'audit (MP §24.17) — lecture seule, permission audit.view.
 * Filtres serveur uniquement (aucun SQL depuis le frontend).
 */
final class AuditController extends Controller
{
    public function index(): string
    {
        Auth::requirePermission('audit.view');

        [$where, $params] = $this->filters();
        $total = (int) (Database::fetchOne("SELECT COUNT(*) c FROM audit_logs a {$where}", $params)['c'] ?? 0);
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 50;
        $rows = Database::fetchAll(
            "SELECT a.*, CONCAT(u.first_name,' ',u.last_name) AS user_name
             FROM audit_logs a LEFT JOIN users u ON u.id = a.user_id
             {$where} ORDER BY a.created_at DESC, a.id DESC LIMIT {$perPage} OFFSET " . (($page - 1) * $perPage),
            $params
        );

        return $this->view('admin/audit', [
            'title' => "Journal d'audit",
            'logs' => $rows,
            'total' => $total,
            'page' => $page,
            'pages' => max(1, (int) ceil($total / $perPage)),
        ]);
    }

    /** @return array{0:string,1:array<string,mixed>} */
    private function filters(): array
    {
        $clauses = [];
        $params = [];
        if (($action = trim((string) ($_GET['action'] ?? ''))) !== '') {
            $clauses[] = 'WHERE a.action LIKE ?';
            $params[':a'] = $action . '%';
        }
        if (($table = trim((string) ($_GET['target'] ?? ''))) !== '') {
            if ($clauses === []) {
                $clauses[] = 'WHERE 1=1';
            }
            $clauses[] = 'AND a.target_table = :t';
            $params[':t'] = mb_substr($table, 0, 80);
        }
        return [implode(' ', $clauses), $params];
    }
}
