<?php

namespace App\Http\Controllers\Rss;

use App\Http\Controllers\Controller;
use App\Http\Resources\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function get($id)
    {
        return Entry::findOrFail($id);
    }

    public function all(Request $request)
    {
        $rules = [
            'search' => 'sometimes|required_without_all:date|alpha_dash',
            'date' => 'sometimes|required_without_all:search|date_format:"Y-m-d"',
        ];

        $this->validate($request, $rules);

        if ($request->has('search')) {
            return Entry::search($request->get('search'));
        } elseif ($request->has('date')) {
            $parts = date_parse($request->get('date'));
            return Entry::findByDate($parts['year'], $parts['month'], $parts['day']);
        } else {
            return Entry::all();
        }
    }
}
