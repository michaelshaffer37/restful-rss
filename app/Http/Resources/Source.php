<?php

namespace App\Http\Resources;

/**
 * Class Source
 *
 * @package App\Http\Resources
 */
class Source extends BaseResource
{
    /**
     * Source Status Constants
     */
    const CREATED = 'CREATED';
    const QUEUED = 'QUEUED';
    const PROCESSING = 'PROCESSING';
    const LOADED = 'LOADED';
    const FAILED = 'FAILED';

    /**
     * @var array
     */
    protected $fillable = [
        '_id',
        'url',
        'name',
        'status',
    ];
}
