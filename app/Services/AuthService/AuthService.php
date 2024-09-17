<?php

namespace App\Services\AuthService;

use App\Models\User;
use Exception;

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
}
