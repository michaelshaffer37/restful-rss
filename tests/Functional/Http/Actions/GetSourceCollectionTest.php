<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Source;

/**
 * Class GetSourceCollectionTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class GetSourceCollectionTest extends GetCollectionTestCase
{
    /**
     * @return \App\Contracts\ResourceRoutable
     */
    public function getResourceInstance(): ResourceRoutable
    {
        return new Source();
    }
}
