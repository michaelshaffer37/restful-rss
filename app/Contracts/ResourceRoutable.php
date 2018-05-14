<?php

namespace App\Contracts;

use Illuminate\Contracts\Routing\UrlRoutable;

/**
 * Interface ResourceRoutable
 *
 * @package App\Contracts
 */
interface ResourceRoutable extends UrlRoutable
{
    /**
     * Return the name of the route to link the resource to.
     *
     * @return string
     */
    public function getRouteName(): string;

    /**
     * A getter for the resource uri built from the route, route key
     *
     * @return string
     */
    public function getUriAttribute();
}
