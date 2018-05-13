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
class LoadFeed extends Action
{
    protected $rules = [
        'url' => 'bail|required|url|active_url',
        'name' => 'required|string|max:64',
    ];

    protected function handle(Request $request)
    {
        $channel = Reader::import($request->get('url'));

        $appNS = Uuid::uuid5(Uuid::NAMESPACE_DNS, $request->getHttpHost());

        $feedUuid = (string)Uuid::uuid5($appNS, $channel->getId());

        $feed = Feed::updateOrCreate(
            ['_id' => $feedUuid],
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
            $id = (string)Uuid::uuid5($feedUuid, $entry->getId() . $feed->feed);

            Entry::updateOrCreate(
                ['_id' => $id],
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
