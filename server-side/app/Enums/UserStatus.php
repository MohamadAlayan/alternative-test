<?php

namespace App\Enums;

use App\Enums\traits\EnumToArray;

enum UserStatus : int
{
    use EnumToArray;

    case ACTIVE = 1;
    case SUSPENDED = 2;
    case DELETED = 3;

    public static function getDescription($value): ?string {
        return match ($value) {
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::DELETED => 'Deleted',
            default => null,
        };
    }

}
