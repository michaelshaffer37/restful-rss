<?php

namespace App\Tests\Functional\Http\Actions;

class GetFeedTest extends GetResourceTestCase
{
    public function getResourcePath(): string
    {
        return 'api/feeds';
    }
}
