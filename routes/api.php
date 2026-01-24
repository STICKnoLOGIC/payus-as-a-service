<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\PayUsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

// Public message routes (no authentication)
Route::prefix('payus')->group(function (): void {
    Route::get('/', [PayUsController::class, 'getRandom'])->name('payus.index');
    Route::get('/tones', [PayUsController::class, 'getTones'])->name('payus.tones');
    Route::get('/professional', [PayUsController::class, 'getProfessional'])->name('payus.professional');
    Route::get('/playful', [PayUsController::class, 'getPlayful'])->name('payus.playful');
    Route::get('/friendly', [PayUsController::class, 'getFriendly'])->name('payus.friendly');
    Route::get('/frank', [PayUsController::class, 'getFrank'])->name('payus.frank');
    Route::get('/funny', [PayUsController::class, 'getFunny'])->name('payus.funny');
});
