<?php

namespace App\Http\Resources;

use App\Events\SourceSaved;

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
    const REQUESTED = 'REQUESTED';
    const QUEUED = 'QUEUED';
    const PROCESSING = 'PROCESSING';
    const LOADED = 'LOADED';
    const FAILED = 'FAILED';

    /**
     * Register the LoadFeed event to trigger every time we save the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => SourceSaved::class
    ];

    /**
     * @var array
     */
    protected $fillable = [
        '_id',
        'url',
        'name',
        'feed',
    ];

    /**
     * Updates the Source Status to one of the status states.
     *
     * @param string $status
     * @param array  $attributes
     *
     * @return bool
     */
    public function updateStatus(string $status, array $attributes = []): bool
    {
        $this->status = $status;
        return $this->update($attributes);
    }
}
