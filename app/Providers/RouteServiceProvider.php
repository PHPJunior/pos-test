<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

            Route::middleware('web')->group(base_path('routes/web.php'));

            // Auth routes
            Route::middleware('web')->group(base_path('domains/Auth/routes/web.php'));
            Route::middleware('api')->prefix('api')->as('api.')->group(base_path('domains/Auth/routes/api.php'));

            // Dashboard routes
            Route::middleware('web')->group(base_path('domains/Dashboard/routes/web.php'));

            // Category routes
            Route::middleware('web')->group(base_path('domains/Category/routes/web.php'));
            Route::middleware(['api', 'auth:sanctum'])->prefix('api')->as('api.')->group(base_path('domains/Category/routes/api.php'));

            // Product routes
            Route::middleware('web')->group(base_path('domains/Product/routes/web.php'));
            Route::middleware(['api', 'auth:sanctum'])->prefix('api')->as('api.')->group(base_path('domains/Product/routes/api.php'));

            // Cart routes
            Route::middleware(['api', 'auth:sanctum'])->prefix('api')->as('api.')->group(base_path('domains/Cart/routes/api.php'));

            // User routes
            Route::middleware('web')->group(base_path('domains/User/routes/web.php'));
        });
    }
}
