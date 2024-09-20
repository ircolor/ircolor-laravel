<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{

    public function register(string $name, string $email, string $password)
    {
        $newUser = User::create([
            "email" => $email,
            "name" => $name,
            'password' => $password
        ]);
        return [
            "success" => true,
            "message" => __("messages.registered_successfully"),
            "data" => [
                "user" => $newUser,
                "token" => $newUser->createToken('api')->plainTextToken
            ],
        ];
    }

    public function loginWithGoogle()
    {
        return rescue(function () {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                return [
                    "success" => true,
                    "data" => $finduser->createToken('api')->plainTextToken,
                    "message" => __("auth.login_successfully"),
                ];
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'email_verified_at' => Carbon::now(),
                    'password' => null
                ]);
                return [
                    "success" => true,
                    "message" => __("auth.login_successfully"),
                    "data" => [
                        "user" => $newUser,
                        "token" => $newUser->createToken('api')->plainTextToken
                    ]
                ];
            }
        }, function () {
            return [
                "success" => false,
                "message" => __("messages.registration_error"),
            ];
        });
    }

    public function login($email, $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return [
                "success" => false,
                "message" => __("auth.wrong_email_or_password"),
            ];
        }
        return [
            "success" => true,
            "message" => __("auth.login_successfully")
        ];
    }
}
