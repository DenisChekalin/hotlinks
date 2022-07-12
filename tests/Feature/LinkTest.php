<?php

declare(strict_types=1);

use App\Contracts\Repository\LinkRepositoryContract;
use App\Models\Link;
use Tests\TestCase;

class LinkTest extends TestCase
{
    private const REDIRECT_URL = 'http://google.com';

    public function assertPreConditions(): void
    {
        $this->linkRepository = app(LinkRepositoryContract::class);
    }

    public function testCreate(): void
    {
        $this->get(route('link.create'))
            ->assertOk()
            ->assertSee('Create new link')
            ->assertViewIs('links.form');
    }

    public function testStore(): void
    {
        $link = new Link();
        $this->linkRepository->store($link, [
            'link' => self::REDIRECT_URL,
            'ttl' => 1,
            'usageLimit' => 100,
        ]);

        $response = $this->followingRedirects()
            ->post(route('link.store'), $link->toArray());

        $response->assertOk()
            ->assertSee('Create new link')
            ->assertViewIs('links.form');
    }

    public function testBrokenLink(): void
    {
        $link = new Link();
        $this->linkRepository->store($link, [
            'link' => self::REDIRECT_URL,
            'ttl' => 90,
            'usageLimit' => 1,
        ]);

        $this->get($link->getShortLink())
            ->assertStatus(302)
            ->assertRedirect($link->getLink());

        $this->followingRedirects()
            ->get($link->getShortLink())
            ->assertNotFound()
            ->assertViewIs('links.notFound');
    }
}
