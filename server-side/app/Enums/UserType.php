<?php

namespace App\Enums;

use App\Enums\traits\EnumToArray;

enum UserType : int
{
    use EnumToArray;

    case ADMIN = 1;
    case USER = 2;

    public static function getDescription($value): ?string {
        return match ($value) {
            self::ADMIN => 'Admin',
            self::USER => 'User',
            default => null,
        };
    }

}
