<?php

namespace App\Tests\Unit\Events;

use App\Events\RequestLoadFeed;
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
        $source = Mockery::mock(Source::class);

        $source->shouldReceive('updateStatus')->with(Source::QUEUED);

        new RequestLoadFeed($source);
    }
}
