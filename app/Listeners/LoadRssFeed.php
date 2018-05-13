<?php

namespace App\Listeners;

use App\Events\LoadFeed;
use App\Http\Resources\Entry;
use App\Http\Resources\Feed;
use App\Http\Resources\Source;
use Illuminate\Contracts\Queue\ShouldQueue;
use Zend\Feed\Reader\Reader;

/**
 * Class LoadRssFeed
 *
 * @package App\Listeners
 */
class LoadRssFeed implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string
     */
    public $queue = 'sources';

    /**
     * Handle the load feed event.
     *
     * @param  \App\Events\LoadFeed $event
     *
     * @return void
     */
    public function handle(LoadFeed $event)
    {
        $event->source->updateStatus(Source::PROCESSING);
        /**
         * Load the Source Url as an RSS Feed.
         */
        $channel = Reader::import($event->source->url);

        /**
         *  Store the information about the RSS Feed to the DB.
         */
        $feed = Feed::updateOrCreate(
            ['_id' => app_uuid($channel->getId())],
            [
                'link' => $channel->getLink(),
                'feed' => $channel->getFeedLink(),
                'title' => trim($channel->getTitle()),
                'description' => trim($channel->getDescription()),
                'properties' => [
                    'author' => $channel->getAuthors(),
                    'language' => $channel->getLanguage(),
                    'copyright' => $channel->getCopyright(),
                    'created' => $channel->getDateCreated(),
                    'modified' => $channel->getDateModified(),
                ]
            ]
        );

        /**
         * Load Each of the entries into the DB
         */
        foreach ($channel as $entry) {
            Entry::updateOrCreate(
                ['_id' => app_uuid($entry->getId() . $feed->feed)],
                [
                    'title' => trim($entry->getTitle()),
                    'link' => trim($entry->getLink()),
                    'feed' => $feed->uri,
                    'description' => trim($entry->getDescription()),
                    'pubDate' => $entry->getDateCreated(),
                    'author' => $entry->getAuthor(),
                    'content' => $entry->getContent(),
                    'media' => $entry->getEnclosure(),
                ]
            );
        }

        $event->source->updateStatus(Source::LOADED, ['feed' => $feed->uri]);
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\LoadFeed $event
     * @param  \Exception           $exception
     *
     * @return void
     */
    public function failed(LoadFeed $event, $exception)
    {
        $event->source->updateStatus(Source::FAILED);
    }
}
