<?php

namespace App\Providers;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::prefix('api')
            ->middleware('api')
            ->name('api.')
            ->group(base_path('routes/api.php'));

        Route::prefix('admin')
            ->middleware(['web', AdminMiddleware::class])
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

        Route::prefix('applicant')
            ->name('applicant.')
            ->group(base_path('routes/applicant.php'));
    }
}
