<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePaletteRequest;
use App\Http\Resources\StorePaletteResource;
use App\Services\ApiResponse\ApiResponseFacade;
use App\Services\Palette\PaletteService;

class PaletteController extends Controller
{
    public function __construct(private PaletteService $paletteService)
    {
    }

    public function store(StorePaletteRequest $request)
    {
        $newPalette = $this->paletteService->store($request->input('colors'));

        return ApiResponseFacade::withSuccess($newPalette->isSuccess())
            ->withMessage($newPalette->getMessage())
            ->withData(new StorePaletteResource($newPalette->getData()))
            ->withStatus(200)
            ->build()->response();
    }
}
