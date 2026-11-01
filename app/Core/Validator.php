<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Validation centralisée des données de formulaire.
 * Règle qualité : messages d'erreur clairs, échec-fast sur les champs requis.
 */
final class Validator
{
    private array $errors = [];

    public function __construct(private readonly array $data)
    {
    }

    public static function make(array $data): self
    {
        return new self($data);
    }

    public function required(string $field, string $label): self
    {
        $v = trim((string) ($this->data[$field] ?? ''));
        if ($v === '') {
            $this->errors[$field][] = "Le champ « {$label} » est obligatoire.";
        }
        return $this;
    }

    public function email(string $field, string $label = 'E-mail'): self
    {
        $v = trim((string) ($this->data[$field] ?? ''));
        if ($v !== '' && filter_var($v, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[$field][] = "Le champ « {$label} » n'est pas un e-mail valide.";
        }
        return $this;
    }

    public function minLength(string $field, int $min, string $label): self
    {
        $v = (string) ($this->data[$field] ?? '');
        if ($v !== '' && mb_strlen($v) < $min) {
            $this->errors[$field][] = "Le champ « {$label} » doit contenir au moins {$min} caractères.";
        }
        return $this;
    }

    public function integer(string $field, string $label): self
    {
        $v = trim((string) ($this->data[$field] ?? ''));
        if ($v !== '' && filter_var($v, FILTER_VALIDATE_INT) === false) {
            $this->errors[$field][] = "Le champ « {$label} » doit être un nombre entier.";
        }
        return $this;
    }

    public function in(string $field, array $allowed, string $label): self
    {
        $v = (string) ($this->data[$field] ?? '');
        if ($v !== '' && !in_array($v, $allowed, true)) {
            $this->errors[$field][] = "Valeur non autorisée pour « {$label} ».";
        }
        return $this;
    }

    /** Contrainte métier explicite (ex. score 0–100). */
    public function range(string $field, float $min, float $max, string $label): self
    {
        $v = $this->data[$field] ?? null;
        if ($v !== null && $v !== '' && !is_numeric($v)) {
            $this->errors[$field][] = "Le champ « {$label} » doit être numérique.";
        } elseif ($v !== null && $v !== '' && ((float) $v < $min || (float) $v > $max)) {
            $this->errors[$field][] = "Le champ « {$label} » doit être entre {$min} et {$max}.";
        }
        return $this;
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }

    public function passes(): bool
    {
        return !$this->fails();
    }

    /** @return array<string, list<string>> */
    public function errors(): array
    {
        return $this->errors;
    }

    /** Première erreur de chaque champ (affichage compact). */
    public function firstErrors(): array
    {
        return array_map(static fn (array $l) => $l[0], $this->errors);
    }
}
