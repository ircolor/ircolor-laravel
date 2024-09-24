<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this['user']->id,
                'email' => $this['user']->email,
                'name' => $this['user']->name,
                'updated_at' => $this['user']->updated_at,
                'created_at' => $this['user']->created_at,
            ],
            'token' => $this['token'],
        ];
    }
}
