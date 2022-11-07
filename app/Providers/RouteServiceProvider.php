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
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api/v1')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('api/fake')
                ->middleware('api')
                ->group(base_path('routes/fake.php'));
            $this->mapAdminRoutes();
        });
    }

    protected function mapAdminRoutes()
    {
        Route::middleware([
            'web'
        ])
            ->name('admin.')
            ->prefix('admin')
            ->group( function ($router) {
                require base_path('routes/admin/auth.php');
            });

        Route::middleware([
            'web',
            'auth.admin',
        ])
            ->name('admin.')
            ->prefix('admin')
            ->group( function ($router) {
                require base_path('routes/admin/global.php');
            });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
