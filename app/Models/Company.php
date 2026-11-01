<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/** Modèle companies (migration 0002). */
final class Company extends Model
{
    protected string $table = 'companies';

    /** @return list<array> Sociétés actives avec compteur de départements. */
    public static function listActive(): array
    {
        return self::query(
            'SELECT c.*, (SELECT COUNT(*) FROM departments d WHERE d.company_id = c.id AND d.archived_at IS NULL) AS departments_count
             FROM companies c WHERE c.archived_at IS NULL ORDER BY c.name'
        );
    }

    public static function create(array $d, ?int $userId): int
    {
        return (new self())->insert([
            'name'       => $d['name'],
            'legal_form' => ($d['legal_form'] ?? '') !== '' ? $d['legal_form'] : null,
            'address'    => ($d['address'] ?? '') !== '' ? $d['address'] : null,
            'city_id'    => ($d['city_id'] ?? 0) > 0 ? (int) $d['city_id'] : null,
            'phone'      => ($d['phone'] ?? '') !== '' ? $d['phone'] : null,
            'email'      => ($d['email'] ?? '') !== '' ? mb_strtolower(trim($d['email'])) : null,
            'website'    => ($d['website'] ?? '') !== '' ? $d['website'] : null,
            'created_by' => $userId,
        ]);
    }

    public static function updateCompany(int $id, array $d): void
    {
        (new self())->update($id, [
            'name'       => $d['name'],
            'legal_form' => ($d['legal_form'] ?? '') !== '' ? $d['legal_form'] : null,
            'address'    => ($d['address'] ?? '') !== '' ? $d['address'] : null,
            'city_id'    => ($d['city_id'] ?? 0) > 0 ? (int) $d['city_id'] : null,
            'phone'      => ($d['phone'] ?? '') !== '' ? $d['phone'] : null,
            'email'      => ($d['email'] ?? '') !== '' ? mb_strtolower(trim($d['email'])) : null,
            'website'    => ($d['website'] ?? '') !== '' ? $d['website'] : null,
        ]);
    }

    public static function archive(int $id): void
    {
        self::query('UPDATE companies SET archived_at = UTC_TIMESTAMP() WHERE id = ?', [$id]);
    }
}
