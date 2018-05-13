<?php

namespace App\Http\Actions;

use App\Http\Resources\Source;
use Illuminate\Http\Request;

/**
 * Class GetSource
 *
 * @package App\Http\Actions
 */
class GetSource extends Action
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function handle(Request $request)
    {
        return Source::findOrFail($this->getRouteParam($request, 'id'));
    }
}
