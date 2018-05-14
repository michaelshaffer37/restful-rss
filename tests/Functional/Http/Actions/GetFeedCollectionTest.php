<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Feed;

/**
 * Class GetFeedCollectionTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class GetFeedCollectionTest extends GetCollectionTestCase
{
    /**
     * @return \App\Contracts\ResourceRoutable
     */
    public function getResourceInstance(): ResourceRoutable
    {
        return new Feed();
    }
}
