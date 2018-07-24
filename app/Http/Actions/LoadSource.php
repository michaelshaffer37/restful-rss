<?php

namespace App\Http\Actions;

use App\Http\Resources\Loader;
use App\Http\Resources\Source;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

/**
 * Class LoadSource
 *
 * @package App\Http\Actions
 */
class LoadSource extends Action
{
    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        /**
         * @var Source $source
         */
        $source = Source::findOrFail($this->getRouteParam($request, 'source'));
        $loader = $source->loaders()->create([
            '_id' => (string)Uuid::uuid4(),
            'status' => Loader::REQUESTED,
        ]);
        return $loader;
    }
}
