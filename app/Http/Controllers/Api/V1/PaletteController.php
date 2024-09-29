<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Palettes\StorePaletteRequest;
use App\Http\Requests\Api\Palettes\UpdatePaletteRequest;
use App\Http\Resources\Palette\PaletteResource;
use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;
use App\Services\ApiResponse\ApiResponseFacade;

class PaletteController extends Controller
{
    public function __construct(private PaletteRepository $paletteRepository) {}

    /**
     * Get list of all palettes
     * @unauthenticated
     */
    public function index()
    {
        return PaletteResource::collection(Palette::with('user')->paginate());
    }

    /**
     * Create new palette
     */
    public function store(StorePaletteRequest $request)
    {
        $newPalette = $this->paletteRepository->store($request->input('colors'));

        return ApiResponseFacade::withSuccess($newPalette->isSuccess())
            ->withMessage($newPalette->getMessage())
            ->withStatus(201)
            ->build()->response();
    }

    /**
     * Update palette
     */
    public function update(UpdatePaletteRequest $request, Palette $palette)
    {
        $this->authorize('update', $palette);
        $updatedPalette = $this->paletteRepository->update($palette, $request->input('colors'));

        return ApiResponseFacade::withSuccess($updatedPalette->isSuccess())
            ->withMessage($updatedPalette->getMessage())
            ->build()->response();
    }

    /**
     * Delete palette
     */
    public function destroy(Palette $palette)
    {
        $this->authorize('destroy', $palette);
        $palette->delete();

        return ApiResponseFacade::withSuccess(true)
            ->withStatus(204)
            ->withMessage(__('messages.deleted_successfully'))
            ->build()->response();
    }

    /**
     * Show palette
     * @unauthenticated
     */
    public function show(Palette $palette)
    {
        views($palette)->record();

        return PaletteResource::make($palette);
    }
}
