<?php

namespace App\Tests\Functional\Listeners;

use App\Events\RequestLoadFeed;
use App\Http\Resources\Loader;
use App\Http\Resources\Source;
use App\Listeners\LoadRssFeed;
use App\Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Ramsey\Uuid\Uuid;

/**
 * Class LoadRssFeedTest
 *
 * @package App\Tests\Functional\Listeners
 */
class LoadRssFeedTest extends TestCase
{
//    use DatabaseTransactions;

    public function testSuccess()
    {
        $this->withoutEvents();
        $loadRssFeed = new LoadRssFeed();

        $source = Source::create([
            '_id' => (string) Uuid::uuid4(),
            'name' => 'FakeTest',
            'url' => 'https://www.nasa.gov/rss/dyn/lg_image_of_the_day.rss'
        ]);

        $loader = new Loader([
            '_id' => (string) Uuid::uuid4(),
            'status' => Loader::REQUESTED,
        ]);

        $loader->source()->associate($source);

        $event = new RequestLoadFeed($loader);

        $loadRssFeed->handle($event);

        $source->delete();
        $loader->delete();
    }
}
