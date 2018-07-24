<?php

namespace App\Http\Actions;

use App\Http\Resources\Loader;
use App\Http\Resources\Source;
use Illuminate\Http\Request;

/**
 * Class GetLoader
 *
 * @package App\Http\Actions
 */
class GetLoader extends Action
{
    public function handle(Request $request)
    {
        $source = Source::findOrFail($this->getRouteParam($request, 'source'));
        $loader = Loader::findOrFail($this->getRouteParam($request, 'id'));
        $source->loaders->all();
        return $loader;
    }
}
