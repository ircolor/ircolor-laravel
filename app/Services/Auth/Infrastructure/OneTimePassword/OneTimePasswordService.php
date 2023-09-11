<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword;

use App\Notifications\OneTimePasswordNotification;
use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordResultInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordVerifierServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordRepositoryInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Auth\Model\OneTimePasswordEntity;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Notification;

/**
 * @extends BaseService<OneTimePasswordRepositoryInterface>
 */
class OneTimePasswordService extends BaseService implements OneTimePasswordServiceInterface
{
    public function __construct(OneTimePasswordRepositoryInterface $repository, protected readonly OneTimePasswordVerifierServiceInterface $verifierService)
    {
        parent::__construct($repository);
    }

    public function createOneTimePasswordWithIdentifier(AuthIdentifierInterface $identifier): OneTimePasswordEntityInterface
    {
        $otp = OneTimePasswordEntity::getBuilder()
            ->as($identifier)
            ->build();

        $this->repository->createOneTimePasswordWithIdentifier($otp);

        Notification::send(null, new OneTimePasswordNotification($identifier, $otp));

        return $otp;
    }

    public function verifyOneTimePassword(AuthIdentifierInterface $identifier, string $token, string $code): OneTimePasswordResultInterface
    {
        $otp = $this->repository->getOneTimePasswordWithIdentifierAndToken($identifier, $token);

        $result = $this->verifierService->verify($otp, $code);

        if ($result->isSuccessful()) {
            $this->repository->removeOneTimePassword($otp);
        }

        return $result;
    }
}
