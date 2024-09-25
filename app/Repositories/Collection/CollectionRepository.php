<?php

namespace App\Repositories\Collection;

use App\Models\Collection;
use App\Services\AuthResult\AuthResultBuilder;
use Illuminate\Support\Facades\Auth;

class CollectionRepository
{

    public function __construct(private AuthResultBuilder $authResultBuilder) {}

    public function all($userId)
    {
        $collections = Collection::where('user_id', $userId)->get();

        return $this->authResultBuilder->setSuccess(true)
            ->setData($collections)
            ->build();
    }

    public function store(string $collectionName)
    {
        $newCollection = Collection::create([
           "name" => $collectionName,
           "user_id" => Auth::guard('sanctum')->user()->id
        ]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.created_successfully'))
            ->setData($newCollection)
            ->build();
    }

    public function update(Collection $collection, string $collectionName)
    {
        $collection->update([
           'name' => $collectionName
        ]);

        return $this->authResultBuilder->setSuccess(true)
            ->setMessage(__('messages.updated_successfully'))
            ->build();
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
    }
}
