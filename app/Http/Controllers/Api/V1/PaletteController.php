<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePaletteRequest;
use App\Http\Requests\Api\UpdatePaletteRequest;
use App\Http\Resources\ColorResource;
use App\Http\Resources\PaletteIndexResource;
use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;
use App\Services\ApiResponse\ApiResponseFacade;

class PaletteController extends Controller
{
    public function __construct(private PaletteRepository $paletteRepository)
    {
    }

    public function index()
    {
        $palettes = Palette::with('user')->paginate(10);
        return ApiResponseFacade::withSuccess(true)
            ->withData(new PaletteIndexResource($palettes))
            ->withMessage('')
            ->build()->response();
    }

    public function store(StorePaletteRequest $request)
    {
        $newPalette = $this->paletteRepository->store($request->input('colors'));

        return ApiResponseFacade::withSuccess($newPalette->isSuccess())
            ->withMessage($newPalette->getMessage())
            ->withStatus(201)
            ->build()->response();
    }

    public function update(UpdatePaletteRequest $request, Palette $palette)
    {
        $this->authorize('update', $palette);
        $updatedPalette = $this->paletteRepository->update($palette, $request->input('colors'));

        return ApiResponseFacade::withSuccess($updatedPalette->isSuccess())
            ->withMessage($updatedPalette->getMessage())
            ->build()->response();
    }

    public function destroy(Palette $palette)
    {
        $this->authorize('destroy', $palette);
        $palette->delete();

        return ApiResponseFacade::withSuccess(true)
            ->withStatus(204)
            ->withMessage(__('messages.palette_deleted_successfully'))
            ->build()->response();
    }

    public function show(Palette $palette)
    {
        views($palette)->record();

        return ApiResponseFacade::withSuccess(true)
            ->withData(new ColorResource($palette))
            ->withMessage(__('messages.palette_deleted_successfully'))
            ->build()->response();
    }
}
