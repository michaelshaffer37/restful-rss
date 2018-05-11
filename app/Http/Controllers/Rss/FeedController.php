<?php

namespace App\Http\Controllers\Rss;

use App\Http\Controllers\Controller;
use App\Http\Resources\Entry;
use App\Http\Resources\Feed;
use Illuminate\Http\Request;
use Zend\Feed\Reader\Reader;

/**
 * Class FeedController
 *
 * @package App\Http\Controllers\Rss
 */
class FeedController extends Controller
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function store(Request $request)
    {
        $channel = Reader::import($request->get('feed'));

        $channel->getId();
        $feed = Feed::updateOrCreate(
            ['feed' => $channel->getLink()],
            [
                'name' => $request->get('name'),
                'link' => $channel->getFeedLink(),
                'title' => $channel->getTitle(),
                'description' => $channel->getDescription(),
                'properties' => [
                    'author' => $channel->getAuthors(),
                    'identifier' => $channel->getId(),
                    'language' => $channel->getLanguage(),
                    'copyright' => $channel->getCopyright(),
                    'created' => $channel->getDateCreated(),
                    'modified' => $channel->getDateModified(),
                ]
            ]
        );

        foreach ($channel as $entry) {
            Entry::updateOrCreate(
                ['link' => $entry->getLink()],
                [
                    'title' => $entry->getTitle(),
                    'description' => $entry->getDescription(),
                    'dateModified' => $entry->getDateModified(),
                    'authors' => $entry->getAuthor(),
                    'content' => $entry->getContent(),
                ]
            );
        }

        return $feed;
    }

    /**
     * @param $feed
     *
     * @return string
     */
    public function get($feed)
    {
        return Feed::findOrFail($feed);
    }

    public function all()
    {
        return Feed::all();
    }
}
