<?php

namespace App\Http\Controllers\Rss;

use App\Http\Controllers\Controller;
use App\Http\Resources\Feed;
use Illuminate\Http\Request;
use MongoDB\Client;
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
     * @return string
     */
    public function storeFeed(Request $request)
    {
        $ns = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'restful_rss.com');
        $channel = Reader::import($request->get('feed'));
        $id = (string)Uuid::uuid5($ns, $request->get('feed'));

        $feed = new Feed([
            '_id' => $id,
            'name' => $request->get('name'),
            'feed' => $channel->getLink(),
            'title' => $channel->getTitle(),
            'description' => $channel->getDescription(),
            'author' => $channel->getAuthor(),
        ]);

        $feed->save();

        return $feed->toJson();
    }

    /**
     * @param $feed
     *
     * @return string
     */
    public function getFeed($feed)
    {
        $feedRecord = (new Feed())->find($feed);

        return $feedRecord->toJson();
    }
}
