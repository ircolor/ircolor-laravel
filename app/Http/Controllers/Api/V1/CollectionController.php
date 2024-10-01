<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Collections\StoreCollectionRequest;
use App\Http\Requests\Api\Collections\UpdateCollectionRequest;
use App\Http\Resources\Collection\CollectionResource;
use App\Models\Collection;
use App\Repositories\Collection\CollectionRepository;
use App\Services\ApiResponse\ApiResponseFacade;

class CollectionController extends Controller
{
    public function __construct(private CollectionRepository $collectionRepository) {}

    /**
     * Get all user's collections
     */
    public function index()
    {
        $collections = $this->collectionRepository->all(auth()->id());

        return CollectionResource::collection($collections->getData());
    }

    /**
     * Create new collection for user
     */
    public function store(StoreCollectionRequest $request)
    {
        $newCollection = $this->collectionRepository->store($request->input('name'));

        return ApiResponseFacade::withMessage($newCollection->getMessage())
            ->withData(new CollectionResource($newCollection->getData()))
            ->withStatus(201)
            ->build()->response();
    }

    /**
     * Update user's collection
     */
    public function update(Collection $collection, UpdateCollectionRequest $request)
    {
        $this->authorize('update', $collection);
        $updateResult = $this->collectionRepository->update($collection, $request->input('name'));

        return ApiResponseFacade::withMessage($updateResult->getMessage())
            ->withStatus(200)
            ->build()->response();
    }

    /**
     * Delete user's collection
     */
    public function destroy(Collection $collection)
    {
        $this->authorize('destroy', $collection);

        if ($collection->name == Collection::DEFAULT_COLLECTION_NAME) {
            return ApiResponseFacade::withStatus(403)
                ->withMessage(__('messages.default_collection_remove_error'))
                ->build()->response();
        }

        $this->collectionRepository->destroy($collection);

        return ApiResponseFacade::withStatus(204)->build()->response();
    }
}
