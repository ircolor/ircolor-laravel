<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePaletteRequest;
use App\Http\Requests\Api\UpdatePaletteRequest;
use App\Http\Resources\PaletteResource;
use App\Models\Palette;
use App\Repositories\Palette\PaletteRepository;
use App\Services\ApiResponse\ApiResponseFacade;
use OpenApi\Annotations as OA;

class PaletteController extends Controller
{
    public function __construct(private PaletteRepository $paletteRepository) {}

    /**
     * @OA\Get(
     *     path="/v1/palettes",
     *     summary="Get list of palettes",
     *     description="Get list of palettes",
     *     tags={"Palettes"},
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="palettes",
     *                     type="array",
     *
     *                     @OA\Items(
     *
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=22
     *                         ),
     *                         @OA\Property(
     *                             property="colors",
     *                             type="array",
     *
     *                             @OA\Items(
     *
     *                                 @OA\Property(
     *                                     property="hex",
     *                                     type="string",
     *                                     example="#abe500"
     *                                 )
     *                             )
     *                         ),
     *                         @OA\Property(
     *                             property="user",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 example="test-name"
     *                             ),
     *                             @OA\Property(
     *                                 property="email",
     *                                 type="string",
     *                                 example="rezatva@gmail.com"
     *                             )
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="meta",
     *                     type="object",
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="first_page_url",
     *                         type="string",
     *                         example="http://ircolor-laravel.com/api/v1/palettes?page=1"
     *                     ),
     *                     @OA\Property(
     *                         property="from",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="last_page",
     *                         type="integer",
     *                         example=2
     *                     ),
     *                     @OA\Property(
     *                         property="last_page_url",
     *                         type="string",
     *                         example="http://ircolor-laravel.com/api/v1/palettes?page=2"
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="array",
     *
     *                         @OA\Items(
     *
     *                             @OA\Property(
     *                                 property="url",
     *                                 type="string",
     *                                 nullable=true,
     *                                 example=null
     *                             ),
     *                             @OA\Property(
     *                                 property="label",
     *                                 type="string",
     *                                 example="« قبلی"
     *                             ),
     *                             @OA\Property(
     *                                 property="active",
     *                                 type="boolean",
     *                                 example=false
     *                             )
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="next_page_url",
     *                         type="string",
     *                         example="http://ircolor-laravel.com/api/v1/palettes?page=2"
     *                     ),
     *                     @OA\Property(
     *                         property="path",
     *                         type="string",
     *                         example="http://ircolor-laravel.com/api/v1/palettes"
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="prev_page_url",
     *                         type="string",
     *                         nullable=true,
     *                         example=null
     *                     ),
     *                     @OA\Property(
     *                         property="to",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=19
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return PaletteResource::collection(Palette::with('user')->paginate());
    }

    /**
     * @OA\Post(
     *     tags={"Palettes"},
     *     path="/v1/palettes",
     *     summary="Create new palette",
     *     description="Create new palette",
     *     security={{"sanctum":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="colors[]",
     *                     type="array",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="#abc123"
     *                     )
     *                 )
     *             ),
     *             encoding={
     *                 "colors[]": {
     *                     "style": "form",
     *                     "explode": true
     *                 }
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="با موفقیت ساخته شد"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="null",
     *                 example="null"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Validation Error"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="colors",
     *                     type="array",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="تکمیل گزینه colors الزامی است"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     tags={"Palettes"},
     *     path="/v1/palettes/{palette}",
     *     summary="update palette",
     *     description="update new palette",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="palette",
     *         in="path",
     *         required=true,
     *         example=1,
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     default="PUT"
     *                 ),
     *                 @OA\Property(
     *                     property="colors[]",
     *                     type="array",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="#abc123"
     *                     )
     *                 )
     *             ),
     *             encoding={
     *                 "colors[]": {
     *                     "style": "form",
     *                     "explode": true
     *                 }
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="با موفقیت آپدیت شد"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="null",
     *                 example="null"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Validation Error"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="colors",
     *                     type="array",
     *
     *                     @OA\Items(
     *                         type="string",
     *                         example="تکمیل گزینه colors الزامی است"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     tags={"Palettes"},
     *     path="/v1/palettes/{palette}",
     *     summary="delete palette",
     *     description="delete palette",
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="palette",
     *         in="path",
     *         required=true,
     *         example=1,
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="successfully deleted"
     *     ),
     *
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     tags={"Palettes"},
     *     path="/v1/palettes/{palette}",
     *     summary="Show palette",
     *     description="Show palette",
     *
     *     @OA\Parameter(
     *         name="palette",
     *         in="path",
     *         required=true,
     *         example=1,
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="hex",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=34,
     *                     ),
     *                     @OA\Property(
     *                         property="colors",
     *                         type="array",
     *
     *                         @OA\Items(
     *                             type="string",
     *                             example="#abe343",
     *                         ),
     *                         @OA\Items(
     *                             type="string",
     *                             example="#abe345",
     *                         ),
     *                     ),
     *
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         example=90,
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-09-24T05:22:59.000000Z",
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-09-24T05:22:59.000000Z",
     *                     ),
     *                     @OA\Property(
     *                         property="views",
     *                         type="integer",
     *                         example=24,
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             default="application/json",
     *         ),
     *     ),
     * )
     */
    public function show(Palette $palette)
    {
        views($palette)->record();

        return PaletteResource::make($palette);
    }
}
