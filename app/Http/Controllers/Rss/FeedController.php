<?php

namespace App\Http\Controllers\Rss;

use App\Http\Controllers\Controller;
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
     *
     * @var Client
     */
    protected $mongoClient;

    public function __construct()
    {
        $this->mongoClient = new Client('mongodb://mongodb/');
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function storeFeed(Request $request)
    {
        $collection = $this->mongoClient->rss->feeds;
        $ns = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'restful_rss.com');
        $channel = Reader::import($request->get('feed'));
        $id = (string) Uuid::uuid5($ns, $request->get('feed'));

        $collection->updateOne(
            [
                '_id' => $id,
            ],
            [
                '$set' => [
                    'name' => $request->get('name'),
                    'feed' => $channel->getLink(),
                    'title' => $channel->getTitle(),
                    'description' => $channel->getDescription(),
                    'author' => $channel->getAuthor(),
                ]
            ],
            ['upsert' => true]);

        return json_encode([
            'id' => $id
        ]);
    }

    /**
     * @param $feed
     *
     * @return string
     */
    public function getFeed($feed)
    {
        $collection = $this->mongoClient->rss->feeds;

        $feedRecord = $collection->findOne(['_id' => $feed]);

        return json_encode($feedRecord);
    }
}
