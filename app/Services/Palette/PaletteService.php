<?php

namespace App\Services\Palette;

use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;

class PaletteService
{
    public function __construct(private PaletteRepository $paletteRepository) {}

    public function all(string $sort = '')
    {

        if ($sort == 'likes') {
            return $this->sortByLikes();

        } elseif ($sort == 'views') {
            return $this->sortByViews();

        } elseif ($sort == 'saves') {
            return $this->sortByCollections();

        } else {
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
}
