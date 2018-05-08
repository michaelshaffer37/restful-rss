<?php

namespace App\Http\Controllers;

use Zend\Feed\Reader\Reader;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function rssTest(Request $request)
    {
        $channel = Reader::import($request->get('url', 'https://www.nasa.gov/rss/dyn/breaking_news.rss'));

        return join(', ', array_filter([$channel->getTitle(), $channel->getLink(), $channel->getDescription()]));
    }
}
