<?php

namespace App\Http\Controllers;

use Zend\Feed\Reader\Reader;
use Illuminate\Http\Request;
use App\Http\GuzzleClient;

class RssController extends Controller
{
    public function rssTest(Request $request)
    {
        Reader::setHttpClient(new GuzzleClient());

        $channel = Reader::import($request->get('url', 'https://www.nasa.gov/rss/dyn/breaking_news.rss'));

        return join(', ', array_filter([$channel->getTitle(), $channel->getLink(), $channel->getDescription()]));
    }
}
