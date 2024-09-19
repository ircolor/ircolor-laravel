<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{

    public function register(array $userInputs)
    {
        $newUser = User::query()->create($userInputs);
        return [
            "success" => true,
            "message" => __("messages.registered_successfully"),
            "data" => $newUser,
        ];
    }

    public function loginWithGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return [
                    "success" => true,
                    "message" => __("auth.login_successfully"),
                ];

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                Auth::login($newUser);
                return [
                    "success" => true,
                    "message" => __("auth.login_successfully"),
                    "data" => $newUser
                ];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => __("messages.registeration_error"),
            ];
        }
    }

    public function login(array $userInputs)
    {
        if (!Auth::attempt($userInputs)) {
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
