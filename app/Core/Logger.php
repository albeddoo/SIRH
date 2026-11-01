<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Logger minimal — écriture JSON Lines dans storage/logs/.
 * Aucune donnée sensible (mot de passe, token CSRF) n'est journalisée en clair.
 */
final class Logger
{
    private static ?string $dir = null;

    public static function init(string $dir): void
    {
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        self::$dir = $dir;
    }

    public static function info(string $message, array $context = []): void
    {
        self::write('INFO', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::write('WARNING', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('ERROR', $message, $context);
    }

    private static function write(string $level, string $message, array $context): void
    {
        // Filtre de sécurité : jamais de secrets en log.
        foreach (['password', 'passwd', '_csrf', 'token', 'session'] as $k) {
            unset($context[$k]);
        }

        $line = json_encode([
            'ts'      => gmdate('Y-m-d\TH:i:s\Z'), // UTC en log
            'level'   => $level,
            'message' => $message,
            'context' => $context ?: null,
        ], JSON_UNESCAPED_UNICODE);

        $file = (self::$dir ?? (dirname(__DIR__, 2) . '/storage/logs')) . '/app.log';
        @file_put_contents($file, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
