<?php

namespace App\Tests\Functional\Http\Actions;

/**
 * Class GetSourceTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class GetSourceTest extends GetResourceTestCase
{
    public function getResourcePath(): string
    {
        return 'api/sources';
    }
}
