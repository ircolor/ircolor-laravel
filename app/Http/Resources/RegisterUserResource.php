<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            "email" => $this->email,
            "name" => $this->name,
            "updated_at" => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            "id" => $this->id,
        ];
    }
}

