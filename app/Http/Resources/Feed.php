<?php

namespace App\Http\Resources;

/**
 * Class Feed
 *
 * @package App\Http\Resources
 */
class Feed extends BaseResource
{
    /**
     * @var array
     */
    protected $fillable = [
        'feed',
        'link',
        'name',
        'title',
        'description',
        'properties',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'properties',
    ];
}
