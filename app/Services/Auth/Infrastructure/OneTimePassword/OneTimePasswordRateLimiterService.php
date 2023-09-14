<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword;

use App\Repositories\Base\Contracts\BaseRepositoryInterface;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordRateLimiterServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Limiter\OneTimePasswordIdentifierLimiter;
use App\Services\Auth\Infrastructure\OneTimePassword\Limiter\OneTimePasswordIpAddressLimiter;
use App\Services\Base\BaseService;
use Illuminate\Container\Container;
use Illuminate\Redis\Connections\Connection;

/**
 * @extends BaseService<BaseRepositoryInterface>
 */
class OneTimePasswordRateLimiterService extends BaseService implements OneTimePasswordRateLimiterServiceInterface
{
    /**
     * @var array<class-string>
     */
    private array $limiters = [
        OneTimePasswordIpAddressLimiter::class,
        OneTimePasswordIdentifierLimiter::class
    ];

    /**
     * @var array<int, object>
     */
    private array $limiterInstances = [];

    public function __construct(protected readonly Connection $connection, private readonly Container $container)
    {
        parent::__construct();
    }

    public function pass(AuthIdentifierInterface $identifier): bool
    {
        if (empty($this->limiterInstances)) {
            $this->createLimiterInstance($identifier);
        }

        foreach ($this->limiterInstances as $limiterInstance) {
            $result = method_exists($limiterInstance, 'pass') ? $limiterInstance->pass($identifier) : false;

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    private function createLimiterInstance(AuthIdentifierInterface $identifier): void
    {
        foreach ($this->limiters as $limiterClass) {
            $this->container
                ->when($limiterClass)
                ->needs(AuthIdentifierInterface::class)
                ->give(fn() => $identifier);

            $this->limiterInstances[] = $this->container->make($limiterClass);
        }
    }
}
