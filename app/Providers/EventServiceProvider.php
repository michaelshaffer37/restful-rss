<?php

namespace App\Providers;

use App\Events\RequestLoadFeed;
use App\Events\SourceSaved;
use App\Listeners\CheckSourceSave;
use App\Listeners\LoadRssFeed;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RequestLoadFeed::class => [
            LoadRssFeed::class,
        ],
    ];
}
