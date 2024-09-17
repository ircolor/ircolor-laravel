<?php

namespace App\Providers;

use App\Http\Resources\RegisterUserResource;
use App\Services\ApiResponseService\ApiResponseBuilder;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('apiResponseFacade', function () {
            return new ApiResponseBuilder();
        });

        $this->app->bind('RegisterUserResource', function ($resource, $params) {
            return new RegisterUserResource($params['data']);
        });
    }
}
