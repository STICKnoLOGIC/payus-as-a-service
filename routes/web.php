<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $markdown = file_get_contents(base_path('README.md'));
    
    // Convert markdown to HTML using Laravel's built-in markdown parser
    $content = Str::markdown($markdown);
    
    return view('welcome', ['content' => $content]);
});