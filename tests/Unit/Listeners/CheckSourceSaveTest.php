<?php

namespace App\Tests\Unit\Listeners;

use App\Events\RequestLoadFeed;
use App\Events\SourceSaved;
use App\Http\Resources\Source;
use App\Listeners\CheckSourceSave;
use App\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

/**
 * Class CheckSourceSaveTest
 *
 * @package App\Tests\Unit\Listeners
 */
class CheckSourceSaveTest extends TestCase
{
    public function testHandleRequestedStatus()
    {
        $event = $this->sourceSavedMock(Source::REQUESTED);

        $listener = app(CheckSourceSave::class);

        $this->expectsEvents(RequestLoadFeed::class);

        $event->source->shouldReceive('updateStatus')->with(Source::QUEUED);

        $listener->handle($event);
    }

    public function testHandleQueuedStatus()
    {
        $event = $this->sourceSavedMock(Source::QUEUED);

        $listener = app(CheckSourceSave::class);

        $this->expectNoEvents();

        $listener->handle($event);
    }

    public function testHandleProcessingStatus()
    {
        $event = $this->sourceSavedMock(Source::PROCESSING);

        $listener = app(CheckSourceSave::class);

        $this->expectNoEvents();

        $listener->handle($event);
    }

    public function testHandleLoadedStatus()
    {
        $event = $this->sourceSavedMock(Source::LOADED);

        $listener = app(CheckSourceSave::class);

        $this->expectNoEvents();

        $listener->handle($event);
    }

    public function testHandleFailedStatus()
    {
        $event = $this->sourceSavedMock(Source::FAILED);

        $listener = app(CheckSourceSave::class);

        $this->expectNoEvents();

        $listener->handle($event);
    }

    public function sourceSavedMock(string $status): SourceSaved
    {
        $source = Mockery::mock(Source::class);

        $source->shouldReceive('setAttribute')->with('status', $status);
        $source->shouldReceive('getAttribute')->with('status')->andReturn($status);
        $source->status = $status;

        $event = new SourceSaved($source);

        return $event;
    }
}
