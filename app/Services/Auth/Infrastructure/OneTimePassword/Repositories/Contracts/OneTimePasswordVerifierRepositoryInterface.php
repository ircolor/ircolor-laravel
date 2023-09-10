<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts;

use App\Repositories\Base\Contracts\BaseRepositoryInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;

interface OneTimePasswordVerifierRepositoryInterface extends BaseRepositoryInterface
{
    public function getFailedAttemptsCount(OneTimePasswordEntityInterface $entity): int;

    public function incrementFailAttemptsCount(OneTimePasswordEntityInterface $entity, int $value = 1): int;
}
