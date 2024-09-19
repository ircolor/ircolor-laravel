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
        try {
            $newUser = User::query()->create($userInputs);

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => __("messages.Something went wrong, please try again later"),
                "data" => "",
            ];
        }
        return [
            "success" => true,
            "message" => __("messages.User has been registered successfully"),
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
                    "message" => __("auth.you have login successfully"),
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
                    "message" => __("auth.you have login successfully"),
                    "data" => $newUser
                ];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => __("messages.Something went wrong, please try again later"),
            ];
        }
    }

    public function login(array $userInputs)
    {
        if (!Auth::attempt($userInputs)) {
            return [
                "success" => false,
                "message" => __("auth.email or password is wrong"),
            ];
        }
        return [
            "success" => true,
            "message" => __("auth.you have login successfully")
        ];
    }
}
