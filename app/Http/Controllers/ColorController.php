<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Colors\ShowColorRequest;
use App\Http\Resources\Color\ColorResource;
use App\Services\ApiResponse\ApiResponseFacade;
use App\Services\Colors\ColorService;

class ColorController extends Controller
{
    public function __construct(private ColorService $colorService) {}

    public function show(ShowColorRequest $request, string $hex)
    {
        $generatedColors = $this->colorService->generateDarkBrightColors($hex, $request->query('qty') ?? 10);

        return ApiResponseFacade::withData(new ColorResource($generatedColors))
            ->build()->response();
    }
}
