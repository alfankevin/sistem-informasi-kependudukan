<?php

namespace App\Enums;

enum GenderEnum: string
{
    case MALE = 'L';
    case FEMALE = 'P';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
