<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Paramètres globaux dynamiques (table settings, migration 0003 ; seed 0007).
 * Les valeurs du référentiel (MP §24.6 / loi 09-08) priment sur les défauts config.
 * Cache par requête ; versionnage via setting_versions géré côté contrôleur admin.
 */
final class Settings
{
    /** @var array<string,mixed>|null */
    private static ?array $cache = null;

    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }
        $out = [];
        try {
            foreach (Database::fetchAll('SELECT setting_key, value_type, value_text FROM settings') as $r) {
                $out[$r['setting_key']] = self::cast($r['value_text'], $r['value_type']);
            }
        } catch (\Throwable $e) {
            // Base non migrée (socle Phase 01) : repli silencieux sur les défauts.
            Logger::warning('Settings indisponibles: ' . $e->getMessage());
        }
        return self::$cache = $out;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $v = self::get($key);
        return $v === null ? $default : (bool) $v;
    }

    public static function int(string $key, int $default = 0): int
    {
        $v = self::get($key);
        return is_numeric($v) ? (int) $v : $default;
    }

    public static function forget(): void
    {
        self::$cache = null;
    }

    private static function cast(?string $text, string $type): mixed
    {
        return match ($type) {
            'int'   => (int) $text,
            'float' => (float) $text,
            'bool'  => in_array(strtolower((string) $text), ['1', 'true', 'yes', 'on'], true),
            'json'  => json_decode((string) $text, true),
            default => $text,
        };
    }
}
