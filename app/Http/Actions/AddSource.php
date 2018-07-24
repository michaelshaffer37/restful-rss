<?php

namespace App\Http\Actions;

use App\Http\Resources\Source;
use Illuminate\Http\Request;

/**
 * Class AddSource
 *
 * @package App\Http\Actions
 */
class AddSource extends Action
{
    /**
     * The Request Validation Rules
     *
     * @var array
     */
    protected $rules = [
        'url' => 'bail|required|url|active_url',
        'name' => 'required|string|max:64',
    ];

    /**
     * Create the Source
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function handle(Request $request)
    {
        /**
         * @var Source $source
         */
        $source = Source::updateOrCreate(
            ['url' => $request->get('url')],
            [
                '_id' => app_uuid($request->get('url')),
                'name' => $request->get('name'),
            ]
        );

        if ($source->wasRecentlyCreated) {
            return response()->json($source, 201);
        } else {
            return response()->json($source);
        }
    }
}
