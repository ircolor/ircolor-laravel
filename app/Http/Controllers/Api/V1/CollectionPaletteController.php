<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionPaletteStoreRequest;
use App\Http\Resources\Collection\CollectionResource;
use App\Models\Collection;
use App\Models\Palette;
use App\Repositories\Collection\CollectionRepository;
use App\Repositories\Palette\PaletteRepository;
use App\Services\ApiResponse\ApiResponseFacade;
use Illuminate\Database\UniqueConstraintViolationException;

class CollectionPaletteController extends Controller
{
    public function __construct(private CollectionRepository $collectionRepository, private PaletteRepository $paletteRepository) {}

    public function store(CollectionPaletteStoreRequest $request, Collection $collection)
    {
        $this->authorize('storePalette', $collection);

        $palette = $this->paletteRepository->findPaletteById($request->input('palette_id'));

        try {
            $palette->storeInCollection($collection);

        } catch (UniqueConstraintViolationException $e) {
            return ApiResponseFacade::withStatus(409)
                ->withMessage(__('messages.previously_added'))
                ->build()->response();
        }

        return ApiResponseFacade::withStatus(200)
            ->withMessage(__('messages.created_successfully'))
            ->build()->response();
    }

    public function destroy(Collection $collection, Palette $palette)
    {
        $this->authorize('removePalette', $collection);
        $palette->removeFromCollection($collection);

        return ApiResponseFacade::withStatus(204)->build()->response();
    }

    public function index(Collection $collection)
    {
        $this->authorize('showPalettes', $collection);

        $collectionPalettes = $this->collectionRepository->show($collection);

        return ApiResponseFacade::withData(new CollectionResource($collectionPalettes->getData()))
            ->build()->response();
    }
}
