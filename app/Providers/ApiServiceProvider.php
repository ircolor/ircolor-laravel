<?php

namespace App\Providers;

use App\Services\ApiResponse\ApiResponseBuilder;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('apiResponseFacade', ApiResponseBuilder::class);
    }
}
