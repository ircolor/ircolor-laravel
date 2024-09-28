<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\Palette\PaletteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'palettes' => $this->whenLoaded('palettes', fn () => PaletteResource::collection($this->palettes)),
        ];
    }
}
