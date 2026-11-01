<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Gestion des flash messages via session.
 */
final class Flash
{
    public static function set(string $type, string $message): void
    {
        $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
    }

    /** @return list<array{type:string, message:string}> Consomme et vide les flashs. */
    public static function pull(): array
    {
        $items = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $items;
    }
}
