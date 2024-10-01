<?php

namespace App\Http\Resources\Color;

use App\Http\Resources\Palette\ColorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HexColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "dark" => ColorResource::collection($this->resource['dark']),
            "bright" => ColorResource::collection($this->resource['bright'])
        ];
    }
}
