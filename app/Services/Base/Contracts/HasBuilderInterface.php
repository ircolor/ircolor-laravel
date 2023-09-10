<?php

namespace App\Services\Base\Contracts;

/**
 * @template TEntity
 */
interface HasBuilderInterface
{
    /**
     * @return EntityBuilderInterface<TEntity>
     */
    public static function getBuilder(): EntityBuilderInterface;
}
