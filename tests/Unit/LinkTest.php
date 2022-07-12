<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Contracts\Repository\LinkRepositoryContract;
use App\Models\Link;
use Tests\TestCase;

class LinkTest extends TestCase
{
    private const REDIRECT_URL = 'http://google.com';

    /**
     * @var LinkRepositoryContract
     */
    private $linkRepository;

    public function assertPreConditions(): void
    {
        $this->linkRepository = app(LinkRepositoryContract::class);
    }

    public function testLinkTtl(): void
    {
        $link = new Link();
        $this->linkRepository->store($link, [
            'link' => self::REDIRECT_URL,
            'ttl' => 1,
            'usageLimit' => 1,
        ]);
        sleep(2);
        $this->assertTrue($this->linkRepository->getForRedirect($link->getHash())->isEmpty());

        $link = new Link();
        $this->linkRepository->store($link, [
            'link' => self::REDIRECT_URL,
            'ttl' => 10,
            'usageLimit' => 1,
        ]);
        $this->assertFalse($this->linkRepository->getForRedirect($link->getHash())->isEmpty());
    }

    public function testLinkUsageCount(): void
    {
        $link = new Link();
        $this->linkRepository->store($link, [
            'link' => self::REDIRECT_URL,
            'ttl' => 100,
            'usageLimit' => 1,
        ]);
        $this->assertFalse($this->linkRepository->getForRedirect($link->getHash())->isEmpty());
        $this->assertTrue($this->linkRepository->getForRedirect($link->getHash())->isEmpty());
    }
}
