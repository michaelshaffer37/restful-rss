<?php

namespace App\Events;

use App\Http\Resources\Source;

/**
 * Class RequestLoadFeed
 *
 * @package App\Events
 */
class RequestLoadFeed extends Event
{
    /**
     * The Source resource for the event to take place on.
     *
     * @var Source
     */
    public $source;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
        $this->source->updateStatus(Source::QUEUED);
    }
}
