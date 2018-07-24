<?php

namespace App\Http\Resources;

use App\Events\RequestLoadFeed;

/**
 * Class Load
 *
 * @package App\Http\Resources
 */
class Loader extends BaseResource
{
    /**
     * Loader Status Constants
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
        'created' => RequestLoadFeed::class
    ];

    /**
     * @var array
     */
    protected $fillable = [
        '_id',
        'source_id',
        'status',
        'feed',
    ];

    protected $hidden = [
        'source',
    ];

    /**
     * Defines the relation between Sources & Loaders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * Define a computed property on all resource models called `uri`.
     *
     * @return string
     */
    public function getUriAttribute()
    {
        return route(
            $this->getRouteName(),
            [$this->getRouteKeyName() => $this->getRouteKey(), 'source' => $this->source->_id]
        );
    }

    /**
     * Updates the Loader Status to one of the status states.
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
