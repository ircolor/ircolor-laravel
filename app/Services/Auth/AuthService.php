<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{

    public function register(array $userInputs)
    {
        $newUser = User::query()->create([
            "email" => $userInputs['email'],
            "name" => $userInputs['name'],
            'password' => $userInputs['password']
        ]);
        $newUser['token'] = $newUser->createToken('api')->plainTextToken;
        return [
            "success" => true,
            "message" => __("messages.registered_successfully"),
            "data" => $newUser,
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
                $newUser['token'] = $newUser->createToken('api')->plainTextToken;
                return [
                    "success" => true,
                    "message" => __("auth.login_successfully"),
                    "data" => $newUser
                ];
            }
        }, function () {
            return [
                "success" => false,
                "message" => __("messages.registeration_error"),
            ];
        });
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
