<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;
use App\Services\Auth\Contracts\Providers\EmailProviderInterface;
use App\Services\Auth\Providers\EmailProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register()
    {
        parent::register();

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(EmailProviderInterface::class, EmailProvider::class);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
