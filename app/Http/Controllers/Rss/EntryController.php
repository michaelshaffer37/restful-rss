<?php

namespace App\Http\Controllers\Rss;

use App\Http\Resources\Entry;
use Illuminate\Http\Request;

class EntryController
{
    public function get($entry)
    {
        return Entry::findOrFail($entry);
    }

    public function all(Request $request)
    {
        if ($request->has('search')) {
            return Entry::search($request->get('search'));
        } else {
            return Entry::all();
        }
    }
}
