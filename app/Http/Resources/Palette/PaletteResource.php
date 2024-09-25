<?php

namespace App\Http\Resources\Palette;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Palette $resource
 */
class PaletteResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'colors' => ColorResource::collection($this->resource->colors),
            'user' => new UserResource($this->resource->user),
        ];
    }
}
