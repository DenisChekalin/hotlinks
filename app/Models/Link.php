<?php

namespace App\Models;

use App\Traits\NullAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link
{
    use HasFactory;
    use NullAble;

    public const MIN_USAGE = 0;
    public const MAX_USAGE = PHP_INT_MAX;

    public const MIN_TTL = 1;
    public const MAX_TTL = 86400;

    private $link;
    private $hash;
    private $usageLimit;
    private $ttl;

    public function getLink(): string
    {
        return (string)$this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getHash(): string
    {
        return (string)$this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getUsageLimit(): int
    {
        return (int)$this->usageLimit;
    }

    public function setUsageLimit(int $usageLimit): void
    {
        $this->usageLimit = $usageLimit;
    }

    public function getTtl(): int
    {
        return (int)$this->ttl;
    }

    public function setTtl(int $ttl): void
    {
        $this->ttl = $ttl;
    }

    public function getShortLink(): string
    {
        return route('redirect', [
            'hash' => $this->getHash(),
        ]);
    }

    public function toArray(): array
    {
        return [
            'link' => $this->getLink(),
            'hash' => $this->getHash(),
            'usageLimit' => $this->getUsageLimit(),
            'ttl' => $this->getTtl(),
        ];
    }
}
