<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Url;

/**
 * Rendu des vues avec layout Bootstrap 5. Échappement systématique exigé
 * dans les vues (htmlspecialchars) — aucune sortie brute non maîtrisée.
 */
final class View
{
    /**
     * @param string $template chemin relatif sous app/Views (ex. "home/index")
     * @param array<string, mixed> $data
     */
    public static function render(string $template, array $data = [], ?string $layout = 'layouts/main'): string
    {
        $viewFile = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $template) . '.php';
        if (!is_file($viewFile)) {
            throw new \RuntimeException("Vue introuvable : {$template}");
        }

        $data['flashes'] = Flash::pull();
        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === null) {
            return $content;
        }

        $layoutFile = dirname(__DIR__) . '/Views/' . $layout . '.php';
        ob_start();
        require $layoutFile; // dispose de $content, $title, $flashes
        return ob_get_clean();
    }

    /** Échappement HTML réutilisable dans les vues. */
    public static function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
