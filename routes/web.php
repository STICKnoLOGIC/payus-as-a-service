<?php

declare(strict_types=1);

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function (): Factory|View {
    $markdown = file_get_contents(base_path('README.md')) ?: 'Welcome to the PayUs-as-a-Service!';

    // Convert markdown to HTML using Laravel's built-in markdown parser
    $content = Str::markdown($markdown);

    return view('welcome', ['content' => $content]);
});
