<?php

namespace App\Tests\Functional\Http\Actions;

class GetEntityTest extends GetResourceTestCase
{

    public function getResourcePath(): string
    {
        return 'api/entries';
    }
}
