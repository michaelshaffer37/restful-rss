<?php

namespace App\Http\Controllers\Rss;

use App\Http\Resources\Entry;
use Illuminate\Http\Request;

class EntryController
{
    public function get($id)
    {
        return Entry::findOrFail($id);
    }

    public function all(Request $request)
    {
        if ($request->has('search')) {
            return Entry::search($request->get('search'));
        } elseif ($request->has('date')) {
            $date = $request->get('date');
            if (!preg_match('/^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})$/', $date)) {
                // Bad Request by Client.
                return response()->json(
                    ['msg' => http_status_code_reason(400) . ': Invalid date format expected YYYY-MM-DD'],
                    400
                );
            }

            $parts = date_parse($request->get('date'));
            return Entry::findByDate($parts['year'], $parts['month'], $parts['day']);
        } else {
            return Entry::all();
        }
    }
}
