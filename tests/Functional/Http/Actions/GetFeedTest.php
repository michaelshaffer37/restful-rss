<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Feed;

class GetFeedTest extends GetResourceTestCase
{
    public function getResourcePath(): string
    {
        return 'api/feeds';
    }

    public function getResourceInstance(): ResourceRoutable
    {
        return new Feed();
    }
}
