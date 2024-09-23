<?php

namespace App\Repositories\Palette;

use App\Models\Palette;
use App\Services\AuthResult\AuthResultBuilder;
use Illuminate\Support\Facades\Auth;

class PaletteRepository
{
    public function __construct(private AuthResultBuilder $authResultBuilder)
    {
    }

    public function store(array $palettes)
    {
        $newPalette = Palette::create([
            'colors' => $palettes,
            'user_id' => Auth::guard('sanctum')->user()->id
        ]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.palette_created_successfully'))
            ->setData($newPalette)
            ->build();
    }

    public function update(Palette $palette, array $colors)
    {
        $palette->update(['colors' => $colors]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.palette_updated_successfully'))
            ->build();
    }

}
