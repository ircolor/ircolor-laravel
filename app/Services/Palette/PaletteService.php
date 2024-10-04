<?php

namespace App\Services\Palette;

use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;

class PaletteService
{
    public function __construct(private PaletteRepository $paletteRepository) {}

    public function all(string $sort = '')
    {
        $result = match ($sort) {
            'likes' => $this->sortByLikes(),
            'views' => $this->sortByViews(),
            'saves' => $this->sortByCollections(),
            'popular' => $this->sortByMostPopular(),
            default => Palette::with('user')->paginate(),
        };

        return $result;
    }

    private function sortByLikes()
    {
        return $this->paletteRepository->sortByLikes();
    }

    private function sortByViews()
    {
        return $this->paletteRepository->sortByViews();
    }

    private function sortByCollections()
    {
        return $this->paletteRepository->sortByCollections();
    }

    private function sortByMostPopular()
    {
        return $this->paletteRepository->sortByMostPopular();
    }
}
