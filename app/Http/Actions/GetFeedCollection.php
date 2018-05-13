<?php

namespace App\Http\Actions;

use App\Http\Resources\Feed;
use Illuminate\Http\Request;

/**
 * Class GetFeedCollection
 *
 * @package App\Http\Actions
 */
class GetFeedCollection extends Action
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function handle(Request $request)
    {
        return Feed::all();
    }
}
