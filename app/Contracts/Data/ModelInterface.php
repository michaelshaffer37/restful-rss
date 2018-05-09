<?php

namespace App\Contracts\Data;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;
use MongoDB\Database;

/**
 * Interface ModelInterface
 *
 * @package App\Contracts\Data
 */
interface ModelInterface extends
    ArrayAccess,
    Arrayable,
    Jsonable,
    JsonSerializable,
    HasAttributes
{
    public function fill(array $attributes): ModelInterface;

    public function save(): bool;

    public function find($id, $attributes = null): ModelInterface;

    public function all($attributes = null): Collection;

    /**
     * Set the mongoDb database instance.
     *
     * @param  \MongoDB\Database $database
     *
     * @return void
     */
    public static function setDatabase(Database $database): void;
}
