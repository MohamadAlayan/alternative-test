<?php

namespace App\Enums;

use App\Enums\traits\EnumToArray;

enum AttachmentType: int
{
    use EnumToArray;

    case PROFILE_IMAGE = 1;
    case MEDIA_IMAGE = 2;
    case MEDIA_VIDEO = 3;
    case MEDIA_AUDIO = 4;
    case MEDIA_DOCUMENT = 5;


    // Return path of attachment type
    public static function getPath($value): ?string
    {
        return match ($value) {
            self::PROFILE_IMAGE => 'image/profile',
            self::MEDIA_IMAGE => 'media/image',
            self::MEDIA_VIDEO => 'media/video',
            self::MEDIA_AUDIO => 'media/audio',
            self::MEDIA_DOCUMENT => 'media/document',
            default => null,
        };
    }
}
