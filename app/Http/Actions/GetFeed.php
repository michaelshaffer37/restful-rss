<?php

namespace App\Http\Actions;

use App\Http\Resources\Feed;
use Illuminate\Http\Request;

/**
 * Class GetFeed
 *
 * @package App\Http\Actions
 */
class GetFeed extends Action
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function handle(Request $request)
    {
        return Feed::findOrFail($this->getRouteParam($request, 'id'));
    }
}
