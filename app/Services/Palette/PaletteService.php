<?php

namespace App\Services\Palette;

use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;

class PaletteService
{
    public function __construct(private PaletteRepository $paletteRepository) {}

    public function all(string $sort = '')
    {
        switch ($sort) {
            case 'likes':
                return $this->sortByLikes();
                break;

            case 'views':
                return $this->sortByViews();
                break;

            case 'saves':
                return $this->sortByCollections();
                break;

            case 'popular':
                return $this->sortByMostPopular();
                break;

            default:
                return Palette::with('user')->paginate();
        }
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
