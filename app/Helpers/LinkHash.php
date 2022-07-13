<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Link;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LinkHash
{
    private const HASH_LENGTH = 8;

    private static function getHash(): string
    {
        return Str::random(self::HASH_LENGTH);
    }

    public static function getOriginalHash(Link $link): string
    {
        $hash = $link->getHash();
        $redisConnection = Redis::connection();
        while ($redisConnection->exists($hash)) {
            $hash = self::getHash();
        }

        return $hash;
    }
}
