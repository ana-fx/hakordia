<?php

namespace App\Support;

class StatusStyle
{
    /**
     * Map of checkout statuses to Tailwind utility classes.
     *
     * @return array<string, array<int, string>>
     */
    public static function badgeClassMap(): array
    {
        return [
            'pending' => ['text-bg-warning'],
            'waiting' => ['text-bg-info'],
            'paid' => ['text-bg-success'],
            'verified' => ['text-bg-primary'],
            'expired' => ['text-bg-danger'],
            'default' => ['text-bg-secondary'],
        ];
    }

    /**
     * Return a space-separated class string for the provided status.
     */
    public static function badgeClasses(string $status): string
    {
        $map = self::badgeClassMap();

        $classes = $map[$status] ?? $map['default'];

        return implode(' ', $classes);
    }
}

