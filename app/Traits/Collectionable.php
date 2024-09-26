<?php

namespace App\Traits;

use App\Models\Collection;

trait Collectionable
{
    public function collections()
    {
        return $this->morphToMany(Collection::class, 'collectionable');
    }

    public function storeInCollection(Collection $collection)
    {
        $this->collections()->attach($collection->id);
    }

    public function removeFromCollection(Collection $collection)
    {
        $this->collections()->detach($collection->id);
    }
}
