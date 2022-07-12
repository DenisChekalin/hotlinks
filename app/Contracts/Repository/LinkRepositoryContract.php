<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Models\Link;

interface LinkRepositoryContract
{
    public function store(Link $link, array $data = []): bool;

    public function getForRedirect(string $hash): Link;
}
