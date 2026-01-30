<?php

declare(strict_types=1);

namespace App\Enums;

enum Language: string
{
    case EN = 'en';
    case FR = 'fr';
    case ES = 'es';

    public function label(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::FR => 'French',
            self::ES => 'Spanish',
        };
    }

    public function locale(): string
    {
        return match ($this) {
            self::EN => 'en_GB',
            self::FR => 'fr_FR',
            self::ES => 'es_ES',
        };
    }
}
