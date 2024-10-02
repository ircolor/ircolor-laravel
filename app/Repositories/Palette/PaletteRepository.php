<?php

namespace App\Repositories\Palette;

use App\Models\Palette;
use App\Services\AuthResult\AuthResultBuilder;
use Illuminate\Support\Facades\Auth;

class PaletteRepository
{
    public function __construct(private AuthResultBuilder $authResultBuilder) {}

    public function store(array $palettes)
    {
        $newPalette = Palette::create([
            'colors' => $palettes,
            'user_id' => Auth::guard('sanctum')->id(),
        ]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.created_successfully'))
            ->setData($newPalette)
            ->build();
    }

    public function update(Palette $palette, array $colors)
    {
        $palette->update(['colors' => $colors]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.updated_successfully'))
            ->build();
    }

    public function findPaletteById($id)
    {
        return Palette::find($id);
    }

    public function sortByLikes()
    {
        return Palette::with('user')->orderByLikes('desc')->paginate();
    }

    public function sortByViews()
    {
        return Palette::with('user')->orderByViews('desc')->paginate();
    }

    public function sortByCollections()
    {
        return Palette::with('user')->orderByCollections('desc')->paginate();
    }

    public function sortByMostPopular()
    {
        return Palette::withCount(['collections', 'likes', 'views'])->get()
            ->map(function ($palette) {
                $palette->score = (Palette::COLLECTION_COEFFICIENT * $palette->collections_count) +
                    (Palette::LIKE_COEFFICIENT * $palette->likes_count) +
                    (Palette::VIEW_COEFFICIENT * $palette->views_count);

                return $palette;
            })
            ->sortByDesc('score');
    }
}
