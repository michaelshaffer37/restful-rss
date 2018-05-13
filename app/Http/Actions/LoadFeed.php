<?php

namespace App\Http\Actions;

use App\Http\Resources\Entry;
use App\Http\Resources\Feed;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Zend\Feed\Reader\Reader;

/**
 * Class LoadFeed
 *
 * @package App\Http\Actions
 */
class LoadFeed extends CreatesResources
{
    protected $rules = [
        'url' => 'bail|required|url|active_url',
        'name' => 'required|string|max:64',
    ];

    protected function handle(Request $request)
    {
        $channel = Reader::import($request->get('url'));

        $feed = Feed::updateOrCreate(
            ['_id' => $this->buildUuid($channel->getId())],
            [
                'name' => $request->get('name'),
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

        foreach ($channel as $entry) {
            Entry::updateOrCreate(
                ['_id' => $this->buildUuid($entry->getId() . $feed->feed)],
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

        return $feed;
    }
}
