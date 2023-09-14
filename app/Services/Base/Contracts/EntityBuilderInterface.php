<?php

namespace App\Services\Base\Contracts;

/**
 * @template TEntity
 */
interface EntityBuilderInterface
{
    /**
     * @return TEntity
     */
    public function build(): mixed;
}
