<?php

namespace App\Services\Auth\SignInMethods;

use App\Models\User;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthExceptionInterface;
use App\Services\Auth\Contracts\AuthSignInMethodInterface;
use App\Services\Auth\Contracts\Credentials\PhoneCredentialInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordServiceInterface;
use App\Services\Auth\Infrastructure\OneTimePassword\Contracts\OneTimePasswordVerifyResultInterface;

class OneTimePasswordSignInMethod implements AuthSignInMethodInterface
{
    public function __construct(protected readonly OneTimePasswordServiceInterface $oneTimePasswordService)
    {
        //
    }

    /**
     * @param User $user
     * @param PhoneCredentialInterface $credential
     * @return User
     * @throws AuthException
     */
    public function __invoke(User $user, PhoneCredentialInterface|AuthCredentialInterface $credential): User
    {
        if ($credential->getOneTimePasswordToken() === null || $credential->getOneTimePassword() === null) {
            throw new \InvalidArgumentException('$token or $code is null in $credential');
        }

        $result = $this->oneTimePasswordService->verifyOneTimePassword($credential->getIdentifier(), $credential->getOneTimePasswordToken(), $credential->getOneTimePassword());

        if (!$result->isSuccessful()) {
            if ($result instanceof OneTimePasswordVerifyResultInterface) {
                throw new AuthException($result->getVerifierError()?->value, 400, $result->getPayload());
            } else {
                $error = $result->getError();

                if ($error instanceof AuthExceptionInterface) {
                    $error = $error->getErrorMessage();
                }elseif ($error instanceof \Exception) {
                    $error = $error->getMessage();
                } else {
                    $error = json_encode($error);
                }

                /**
                 * @var string|null $error
                 */
                throw new AuthException($error, 400, $result->getPayload());
            }
        }

        return $user;
    }

    public function getUserRequiredColumns(): array
    {
        return [
            'id',
            'mobile'
        ];
    }
}
