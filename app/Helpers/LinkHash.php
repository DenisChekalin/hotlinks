<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Link;
use Illuminate\Support\Str;

class LinkHash
{
    private const HASH_LENGTH = 8;

    public static function getHash(Link $link): string
    {
        return Str::random(self::HASH_LENGTH);
    }
}
