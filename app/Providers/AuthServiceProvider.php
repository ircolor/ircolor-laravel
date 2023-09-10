<?php

namespace App\Providers;

use App\Repositories\Auth\Contracts\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;
use App\Services\Auth\AuthExceptionConverter;
use App\Services\Auth\AuthService;
use App\Services\Auth\Contracts\AuthExceptionConverterInterface;
use App\Services\Auth\Contracts\AuthProviderInterface;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Services\Auth\Contracts\Providers\EmailProviderInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordVerifierServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\OneTimePasswordService;
use App\Services\Auth\Infrastructure\OneTimePassword\OneTimePasswordVerifierService;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordRepositoryInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordVerifierRepositoryInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\OneTimePasswordRepository;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\OneTimePasswordVerifierRepository;
use App\Services\Auth\Providers\AuthProvider;
use App\Services\Auth\Providers\EmailProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public const CONTAINER_ALIAS_AUTH_PROVIDER_PREFIX = 'auth.provider.';
    public const CONTAINER_ALIAS_AUTH_PROVIDER_TEMPLATE = self::CONTAINER_ALIAS_AUTH_PROVIDER_PREFIX . '%s';

    /**
     * @type array<class-string<AuthProviderInterface>, class-string<AuthProvider>>
     */
    protected const AUTH_PROVIDERS = [
        EmailProviderInterface::class => EmailProvider::class
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register(): void
    {
        parent::register();

        $this->registerRepositories();

        $this->registerAuthProviders();

        $this->app->bind(OneTimePasswordVerifierServiceInterface::class, OneTimePasswordVerifierService::class);
        $this->app->bind(OneTimePasswordServiceInterface::class, OneTimePasswordService::class);
        $this->app->bind(AuthExceptionConverterInterface::class, AuthExceptionConverter::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    private function registerRepositories(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OneTimePasswordRepositoryInterface::class, OneTimePasswordRepository::class);
        $this->app->bind(OneTimePasswordVerifierRepositoryInterface::class, OneTimePasswordVerifierRepository::class);
    }

    private function registerAuthProviders(): void
    {
        foreach (self::AUTH_PROVIDERS as $providerAbstract => $providerInstance) {
            $this->app->bind($providerAbstract, $providerInstance);
            $this->app->alias($providerAbstract, sprintf(self::CONTAINER_ALIAS_AUTH_PROVIDER_TEMPLATE, $providerInstance::ID));
        }
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
