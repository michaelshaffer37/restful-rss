<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

/**
 * Class Entry
 *
 * @package App\Http\Resources
 */
class Entry extends BaseResource
{
    /**
     * The list of attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'title',
        'description',
        'dateModified',
        'authors',
        'content',
    ];

    public static function search(string $terms): Collection
    {
        $projection = ['score' => ['$meta' => 'textScore']];
        $sort = ['score'];

        $docs = (new static)->raw()->find(
            ['$text' => ['$search' => $terms]],
            [
                '$projection' => $projection,
                '$sort' => $sort,
            ]
        );
        $found = array_map(
            function ($doc) {
                return (new static)->newFromBuilder($doc);
            },
            iterator_to_array($docs, false)
        );

        return collect($found);
    }
}
