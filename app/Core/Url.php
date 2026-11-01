<?php

declare(strict_types=1);

namespace App\Core;

/**
 * URL de base calculée dynamiquement → compatibilité sous-dossier local
 * (ex. http://localhost/SIRH/public/). Aucun chemin codé en dur (MP V3 §28).
 */
final class Url
{
    private static ?string $basePath = null;

    /** Préfixe de l'app sur le serveur, ex. "/SIRH/public". */
    public static function basePath(): string
    {
        if (self::$basePath !== null) {
            return self::$basePath;
        }

        // En CLI (migrations), pas de BASE_PATH : vide.
        if (PHP_SAPI === 'cli') {
            return self::$basePath = '';
        }

        $docRoot  = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
        $pubDir   = realpath(dirname(__DIR__, 2) . '/public');

        if ($docRoot !== false && $pubDir !== false && str_starts_with($pubDir, $docRoot)) {
            $prefix = str_replace('\\', '/', substr($pubDir, strlen($docRoot))); // "/SIRH/public"
        } else {
            // Repli : répertoire du script front sans le nom de fichier.
            $prefix = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        }

        return self::$basePath = ($prefix === '/' || $prefix === '') ? '' : $prefix;
    }

    /** Génère une URL absolue locale depuis un chemin relatif ("", "login", "candidats/1"). */
    public static function to(string $path = ''): string
    {
        $path = ltrim($path, '/');
        return self::basePath() . '/' . $path;
    }

    /** URL d'un asset public. */
    public static function asset(string $path): string
    {
        return self::to('assets/' . ltrim($path, '/'));
    }
}
