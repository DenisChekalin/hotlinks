<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Repository\LinkRepositoryContract;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{
    public function index(): Response
    {
        return response('test');
    }

    public function create(): Response
    {
        return response(view('links.form', [
            'entity' => Link::null(),
            'title' => 'Create new link',
        ]));
    }

    public function store(Link $entity, LinkRequest $request, LinkRepositoryContract $repository): RedirectResponse
    {
        $repository->store($entity, $request->all());
        $redirectLink = $entity->getShortLink();

        return Redirect::to(route('link.create'))
            ->with(
                'success',
                'Link was created: <a href="' . $redirectLink . '" target="_blank">' . $redirectLink . '</a>'
            );
    }
}
