<?php

namespace App\Providers;

use App\Contracts\Repository\LinkRepositoryContract;
use App\Repositories\LinkRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LinkRepositoryContract::class, LinkRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
