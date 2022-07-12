<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repository\LinkRepositoryContract;
use App\Exceptions\BrokenHotlinkException;
use App\Helpers\LinkHash;
use App\Models\Link;
use Illuminate\Support\Facades\Redis;

class LinkRepository implements LinkRepositoryContract
{
    private $redisConnection;

    public function __construct()
    {
        $this->redisConnection = Redis::connection();
    }

    public function store(Link $link, array $data = []): bool
    {
        $link->setLink($data['link'] ?? '');
        $link->setUsageLimit((int)($data['usageLimit'] ?? Link::MIN_USAGE));
        $link->setTtl((int)($data['ttl'] ?? Link::MIN_TTL));
        $this->prepareBeforeStore($link);
        return $this->save($link);
    }

    private function prepareBeforeStore(Link $link): void
    {
        if (empty($link->getHash())) {
            $link->setHash(LinkHash::getHash($link));
        }
    }

    private function save(Link $link): bool
    {
        return $this->redisConnection->set($link->getHash(), serialize($link), 'EX', $link->getTtl());
    }

    private function delete(Link $link): void
    {
        $this->redisConnection->del($link->getHash());
    }

    /**
     * @throws BrokenHotlinkException
     */
    private function getByHash(string $hash): Link
    {
        $link = null;

        try {
            $linkSerialized = $this->redisConnection->get($hash);
            if ($linkSerialized === null) {
                throw new BrokenHotlinkException();
            }
            $link = unserialize($linkSerialized, ['allowed_classes' => [Link::class]]);
        } catch (\Exception $exception) {
            throw new BrokenHotlinkException();
        }

        return $link ?? Link::null();
    }

    public function getForRedirect(string $hash): Link
    {
        $link = null;
        try {
            $link = $this->getByHash($hash);
        } catch (BrokenHotlinkException $exception) {
            $link = Link::null();
        }

        if (!$link->isEmpty()) {
            if ($link->getUsageLimit() === 1) {
                $this->delete($link);
            } elseif ($link->getUsageLimit() > 1) {
                $link->setUsageLimit($link->getUsageLimit() - 1);
                $this->save($link);
            }
        }

        return $link;
    }
}
