<?php

declare(strict_types=1);

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Scramble::ignoreDefaultRoutes();
        Scramble::registerUiRoute('docs');
        Scramble::registerJsonSpecificationRoute('api.json');

        // Enable in all environments (or add condition: if (app()->environment('local', 'production')))
        Scramble::extendOpenApi(function ($openApi) {
            $openApi->secure(
                Scramble::defineSecurityScheme('api_key', [
                    'type' => 'apiKey',
                    'in' => 'header',
                    'name' => 'Authorization',
                ])
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    private function configureRateLimiting(): void
    {
        // Default API rate limiter - 60 requests per minute per IP
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->ip()));
    }
}
