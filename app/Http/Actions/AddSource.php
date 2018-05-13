<?php

namespace App\Http\Actions;

use App\Http\Resources\Source;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

/**
 * Class AddSource
 *
 * @package App\Http\Actions
 */
class AddSource extends CreatesResources
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
        return Source::updateOrCreate(
            ['url' => $request->get('url')],
            [
                '_id' => $this->buildUuid($request->get('url')),
                'name' => $request->get('name'),
                'status' => Source::CREATED,
            ]
        );
    }
}
