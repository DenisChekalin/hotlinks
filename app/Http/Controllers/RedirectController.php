<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Repository\LinkRepositoryContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class RedirectController extends Controller
{
    public function show(string $hash, LinkRepositoryContract $repository): SymfonyResponse
    {
        $link = $repository->getForRedirect($hash);

        if ($link->isEmpty()) {
            return response(view('links.notFound'), 404);
        }

        return redirect($link->getLink());
    }
}
