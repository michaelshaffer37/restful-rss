<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Source;

/**
 * Class GetSourceTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class GetSourceTest extends GetResourceTestCase
{
    public function getResourceInstance(): ResourceRoutable
    {
        return new Source();
    }
}
