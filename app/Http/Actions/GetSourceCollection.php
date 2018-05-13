<?php

namespace App\Http\Actions;

use App\Http\Resources\Source;
use Illuminate\Http\Request;

/**
 * Class GetSourceCollection
 *
 * @package App\Http\Actions
 */
class GetSourceCollection extends Action
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function handle(Request $request)
    {
        return Source::all();
    }
}
