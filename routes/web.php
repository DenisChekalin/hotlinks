<?php

declare(strict_types=1);

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::resource('link', LinkController::class)
    ->only([
        'index',
        'create',
        'store',
    ]);

Route::get('redirect/{hash}', [RedirectController::class, 'show'])
    ->where('hash', '[A-Za-z0-9]{8,8}')
    ->name('redirect');
