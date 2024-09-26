<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Collections\StoreCollectionRequest;
use App\Http\Requests\Api\Collections\UpdateCollectionRequest;
use App\Http\Resources\Collection\CollectionResource;
use App\Models\Collection;
use App\Models\Palette;
use App\Repositories\Collection\CollectionRepository;
use App\Services\ApiResponse\ApiResponseFacade;
use Illuminate\Database\UniqueConstraintViolationException;

class CollectionController extends Controller
{

    const DEFAULT_COLLECTION_NAME = 'all';

    public function __construct(private CollectionRepository $collectionRepository) {}

    public function index()
    {
        $collections = $this->collectionRepository->all(auth()->guard('sanctum')->user()->id);

        return CollectionResource::collection($collections->getData());
    }

    public function store(StoreCollectionRequest $request)
    {
        $newCollection = $this->collectionRepository->store($request->input('name'));

        return ApiResponseFacade::withMessage($newCollection->getMessage())
            ->withData(new CollectionResource($newCollection->getData()))
            ->withStatus(201)
            ->build()->response();
    }

    public function update(Collection $collection, UpdateCollectionRequest $request)
    {
        $this->authorize('update', $collection);
        $updateResult = $this->collectionRepository->update($collection, $request->input('name'));

        return ApiResponseFacade::withMessage($updateResult->getMessage())
            ->withStatus(200)
            ->build()->response();
    }

    public function destroy(Collection $collection)
    {
        $this->authorize('destroy', $collection);

        if($collection->name == self::DEFAULT_COLLECTION_NAME){
            return ApiResponseFacade::withStatus(403)
                ->withMessage(__('messages.default_collection_remove_error'))
                ->build()->response();
        }

        $this->collectionRepository->destroy($collection);

        return ApiResponseFacade::withStatus(204)->build()->response();
    }

    public function storePalette(Collection $collection, Palette $palette)
    {
        $this->authorize('storePalette', $collection);

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

    public function removePalette(Collection $collection, Palette $palette)
    {
        $this->authorize('removePalette', $collection);
        $palette->removeFromCollection($collection);

        return ApiResponseFacade::withStatus(204)->build()->response();
    }
}
