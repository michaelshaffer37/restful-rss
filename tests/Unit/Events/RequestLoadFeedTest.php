<?php

namespace App\Tests\Unit\Events;

use App\Events\RequestLoadFeed;
use App\Http\Resources\Loader;
use App\Http\Resources\Source;
use Mockery;
use App\Tests\TestCase;

/**
 * Class RequestLoadFeedTest
 *
 * @package App\Tests\Unit\Events
 */
class RequestLoadFeedTest extends TestCase
{
    public function testUpdateStatus()
    {
        $source = Mockery::mock(Loader::class);

        $event = new RequestLoadFeed($source);

        $this->assertInstanceOf(Loader::class, $event->loader);
    }
}
