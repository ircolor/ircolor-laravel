<?php

namespace App\Services\Auth\Infrastructure\OneTimePassword;

use App\Services\Auth\Contracts\AuthIdentifierInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordRateLimiterServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordResultInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordVerifierServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Enum\OneTimePasswordError;
use App\Services\Auth\Infrastructure\OneTimePassword\Enum\OneTimePasswordVerifyError;
use App\Services\Auth\Infrastructure\OneTimePassword\Model\OneTimePasswordVerifyResult;
use App\Services\Auth\Infrastructure\OneTimePassword\Repositories\Contracts\OneTimePasswordRepositoryInterface;
use App\Services\Auth\Model\Contracts\OneTimePasswordEntityInterface;
use App\Services\Auth\Model\OneTimePasswordEntity;
use App\Services\Base\BaseService;

/**
 * @extends BaseService<OneTimePasswordRepositoryInterface>
 */
class OneTimePasswordService extends BaseService implements OneTimePasswordServiceInterface
{
    public function __construct(OneTimePasswordRepositoryInterface $repository, protected readonly OneTimePasswordRateLimiterServiceInterface $rateLimiterService, protected readonly OneTimePasswordVerifierServiceInterface $verifierService)
    {
        parent::__construct($repository);
    }

    public function createOneTimePasswordWithIdentifier(AuthIdentifierInterface $identifier): OneTimePasswordEntityInterface
    {
        if (!$this->rateLimiterService->pass($identifier)) {
            //TODO: Returning result interface may be better approach
            throw new AuthException(OneTimePasswordError::RATE_LIMIT_EXCEEDED->value, 429);
        }

        $otp = OneTimePasswordEntity::getBuilder()
            ->as($identifier)
            ->build();

        $this->repository->createOneTimePasswordWithIdentifier($otp);

        return $otp;
    }

    public function verifyOneTimePassword(AuthIdentifierInterface $identifier, string $token, string $code): OneTimePasswordResultInterface
    {
        $otp = $this->repository->getOneTimePasswordWithIdentifierAndToken($identifier, $token);

        if ($otp === null) {
            return OneTimePasswordVerifyResult::getBuilder()
                ->failed(OneTimePasswordVerifyError::TOKEN_NOT_FOUND)
                ->build();
        }

        $result = $this->verifierService->verify($otp, $code);
        if ($result->isSuccessful()) {
            $this->repository->removeOneTimePassword($otp);
        }

        return $result;
    }
}
