<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Entry;

class GetEntityTest extends GetResourceTestCase
{
    public function getResourcePath(): string
    {
        return 'api/entries';
    }

    public function getResourceInstance(): ResourceRoutable
    {
        return new Entry();
    }
}
