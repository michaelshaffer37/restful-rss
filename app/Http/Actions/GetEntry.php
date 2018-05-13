<?php

namespace App\Http\Actions;

use App\Http\Resources\Entry;
use Illuminate\Http\Request;

/**
 * Class GetEntry
 *
 * @package App\Http\Actions
 */
class GetEntry extends Action
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function handle(Request $request)
    {
        return Entry::findOrFail($this->getRouteParam($request, 'id'));
    }
}
