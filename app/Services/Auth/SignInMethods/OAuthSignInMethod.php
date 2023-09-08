<?php

namespace App\Services\Auth\SignInMethods;

use App\Models\User;
use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\AuthSignInMethodInterface;
use App\Services\Auth\Contracts\Credentials\GoogleCredentialInterface;
use App\Services\Auth\Contracts\Exceptions\AuthException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class OAuthSignInMethod implements AuthSignInMethodInterface
{
    /**
     * @param User $user
     * @param GoogleCredentialInterface $credential
     * @return User
     * @throws AuthException
     */
    public function __invoke(User $user, GoogleCredentialInterface|AuthCredentialInterface $credential): User
    {
        try {
            /**
             * @var GoogleProvider $socialite
             */
            $socialite = Socialite::driver($credential->getProviderId());

            $oauthUser = $socialite->userFromToken($credential->getIdToken());

            //TODO: Implement this
            dump($oauthUser);
        } catch (\Exception $e) {
            throw new AuthException('auth.oauth_error', 400, ['e' => $e]);
        }

        return $user;
    }
}
