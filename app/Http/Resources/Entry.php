<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use MongoDB\BSON\UTCDateTime;
use DateTime;

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'dateModified'
    ];

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return Collection
     */
    public static function findByDate(int $year, int $month, int $day): Collection
    {

        $startOfDay = new UTCDateTime(new DateTime(sprintf('%d-%02d-%02dT00:00:00Z', $year, $month, $day)));
        $endOfDay = new UTCDateTime(new DateTime(sprintf('%d-%02d-%02dT23:59:59Z', $year, $month, $day)));

        $docs = (new static)->raw()->find(
            ['dateModified' => ['$gt' => $startOfDay, '$lt' => $endOfDay]],
            ['$sort' => ['dateModified']]
        );

        return static::docsToCollection($docs);
    }

    /**
     * @param string $terms
     *
     * @return Collection
     */
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

        return static::docsToCollection($docs);
    }
}
