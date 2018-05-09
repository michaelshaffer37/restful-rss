<?php

namespace App\Contracts\Data;

/**
 * Interface HasAttributes
 *
 * @package App\Contracts\Data
 */
interface HasAttributes
{
    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes(): array;

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value): HasAttributes;
}
