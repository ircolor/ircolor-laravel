<?php

namespace App\Services\Base;

use App\Repositories\Base\Contracts\BaseRepositoryInterface;
use App\Services\Base\Contracts\BaseServiceInterface;

/**
 * @template TRepo
 *
 * @property-read TRepo $repository
 */
abstract class BaseService implements BaseServiceInterface
{
    public function __construct(protected readonly ?BaseRepositoryInterface $repository = null)
    {
        //
    }

    public function hasRepository(): bool
    {
        return $this->repository !== null;
    }

    public function throwIfRepositoryNotProvided(): void
    {
        if (!$this->hasRepository())
            throw new \InvalidArgumentException('$repository not provided');
    }
}
