<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\AuthResult\AuthResultBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{

    public function __construct(private AuthResultBuilder $authResultBuilder)
    {
    }

    public function register(string $name, string $email, string $password)
    {
        $newUser = User::create([
            "email" => $email,
            "name" => $name,
            'password' => $password
        ]);

        return $this->authResultBuilder->setSuccess(true)
            ->setData([
                "user" => $newUser,
                "token" => $newUser->createToken('api')->plainTextToken
            ])->setMessage(__("messages.registered_successfully"))
            ->build();
    }

    public function loginWithGoogle()
    {
        return rescue(function () {
            /**
             * @var \Laravel\Socialite\Two\User $user
             */
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                return $this->authResultBuilder->setSuccess(true)
                    ->setMessage(__("auth.login_successfully"))
                    ->setData(['token' => $finduser->createToken('api')->plainTextToken])
                    ->build();

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'email_verified_at' => Carbon::now(),
                    'password' => null
                ]);
                return $this->authResultBuilder->setSuccess(true)
                    ->setMessage(__("auth.login_successfully"))
                    ->setData([
                        "user" => $newUser,
                        "token" => $newUser->createToken('api')->plainTextToken
                    ])->build();
            }
        }, function () {
            return $this->authResultBuilder->setSuccess(false)
                ->setMessage(__("messages.registration_error"))
                ->build();
        });
    }

    public function login($email, $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {

            return $this->authResultBuilder
                ->setSuccess(false)
                ->setMessage(__("auth.wrong_email_or_password"))
                ->build();
        }
        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__("auth.login_successfully"))
            ->setData([
                "token" => auth()->user()->createToken('api-token')->plainTextToken,
            ])
            ->build();
    }
}
