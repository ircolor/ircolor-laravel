<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaletteIndexResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'palettes' => $this->collection->transform(function ($palette) {
                return [
                    'id' => $palette->id,
                    'colors' => ColorResource::collection($palette->colors),
                    'user' => new UserResource($palette->user)
                ];
            }),
           "meta" =>  collect($this->resource)->forget('data')->all()
        ];
    }
}
