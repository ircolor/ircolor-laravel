<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class AuthRegisterRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|min:5|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:255|confirmed"
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'password' => Hash::make($this->password)
        ]);
    }
}
