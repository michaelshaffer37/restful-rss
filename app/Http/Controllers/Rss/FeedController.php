<?php

namespace App\Http\Controllers\Rss;

use App\Http\Controllers\Controller;
use App\Http\Resources\Entry;
use App\Http\Resources\Feed;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
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
     * @return \App\Http\Resources\BaseResource
     */
    public function store(Request $request)
    {
        $rules = [
            'url' => 'bail|required|url|active_url',
            'name' => 'required|string|alpha_dash|max:255',
        ];

        $validator = app('validator')->make($request->all(), $rules);

        if ($validator->fails()) {
            return abort(400);
        }

        $channel = Reader::import($request->get('url'));

        $appNS = Uuid::uuid5(Uuid::NAMESPACE_DNS, $request->getHttpHost());

        $feedUuid = (string) Uuid::uuid5($appNS, $channel->getId());

        $feed = Feed::updateOrCreate(
            ['_id' => $feedUuid],
            [
                'name' => $request->get('name'),
                'link' => $channel->getLink(),
                'feed' => $channel->getFeedLink(),
                'title' => $channel->getTitle(),
                'description' => $channel->getDescription(),
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
            $id = (string) Uuid::uuid5($feedUuid, $entry->getId() . $feed->feed);

            Entry::updateOrCreate(
                ['_id' => $id],
                [
                    'title' => $entry->getTitle(),
                    'link' => $entry->getLink(),
                    'feed' => $feed->uri,
                    'description' => $entry->getDescription(),
                    'pubDate' => $entry->getDateCreated(),
                    'author' => $entry->getAuthor(),
                    'content' => $entry->getContent(),
                    'media' => $entry->getEnclosure(),
                ]
            );
        }

        return $feed;
    }

    /**
     * @param $feed
     *
     * @return \App\Http\Resources\BaseResource
     */
    public function get($id)
    {
        return Feed::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Feed::all();
    }
}
