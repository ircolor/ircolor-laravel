<?php

namespace App\Http\Requests\Api\Colors;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShowColorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hex' => ['required', 'regex:/^[0-9a-fA-F]{6}$|[0-9a-fA-F]{3}$/'],
        ];
    }

    public function validationData()
    {
        return array_merge($this->request->all(), $this->route()->parameters());
    }
}
