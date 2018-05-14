<?php

namespace App\Http\Actions;

use App\Http\Resources\Entry;
use Illuminate\Http\Request;

/**
 * Class GetEntryCollection
 *
 * @package App\Http\Actions
 */
class GetEntryCollection extends Action
{
    /**
     * The rules to validate against the incoming request
     *
     * @var array
     */
    protected $rules = [
        'search' => 'sometimes|regex:/^[\w\d- ]{3,}$/',
        'date' => 'sometimes|date_format:"Y-m-d"',
    ];

    /**
     * Handle the Querying of the Entry Collection or just get it all.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function handle(Request $request)
    {
        if ($request->has(['search', 'date'])) {
            abort(422);
        } elseif ($request->has('search')) {
            return Entry::search($request->get('search'));
        } elseif ($request->has('date')) {
            $parts = date_parse($request->get('date'));
            return Entry::findByDate($parts['year'], $parts['month'], $parts['day']);
        } else {
            return Entry::all();
        }
    }
}
