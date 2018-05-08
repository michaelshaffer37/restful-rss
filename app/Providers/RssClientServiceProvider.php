<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\RssClient;
use Zend\Feed\Reader\Reader;

class RssClientServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Reader::setHttpClient(new RssClient());
    }
}
