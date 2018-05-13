<?php

namespace App\Listeners;

use App\Events\RequestLoadFeed;
use App\Events\SourceSaved;
use App\Http\Resources\Source;

/**
 * Class CheckSourceSave
 *
 * @package App\Listeners
 */
class CheckSourceSave
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'sync';

    /**
     * Check the Source for the Created Status and dispatch a LoadFeed event if it is 'created'
     *
     * @param SourceSaved $sourceSaved
     */
    public function handle(SourceSaved $sourceSaved)
    {
        if ($sourceSaved->source->status === Source::REQUESTED) {
            event(new RequestLoadFeed($sourceSaved->source));
            // dispatch(new LoadRssFeed($sourceSaved->source));
            $sourceSaved->source->updateStatus(Source::QUEUED);
        }
    }
}
