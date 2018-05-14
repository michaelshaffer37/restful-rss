<?php

namespace App\Tests\Unit\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Tests\TestCase;
use Mockery;

/**
 * Class BaseResourceTest
 *
 * @package App\Tests\Functional\Http\Resources
 */
class BaseResourceTest extends TestCase
{
    public function testGetRouteName()
    {
        /**
         * @var \App\Http\Resources\BaseResource $mockResource
         */
        $mockResource = $this->getItemMock('\App\Http\Resources\Item');

        $this->assertSame('item', $mockResource->getRouteName());
    }

    public function testGetRouteCollectionName()
    {
        /**
         * @var \App\Http\Resources\BaseResource $mockResource
         */
        $mockResource = $this->getItemMock('\App\Http\Resources\Item');

        $this->assertSame('items', $mockResource->getCollectionName());
    }

    public function testGetRouteKeyName()
    {
        /**
         * @var \App\Http\Resources\BaseResource $mockResource
         */
        $mockResource = $this->getItemMock('\App\Http\Resources\Item');

        $this->assertSame('id', $mockResource->getRouteKeyName());
    }

    public function testGetUri()
    {
        /**
         * @var \App\Http\Resources\BaseResource $mockResource
         */
        $mockResource = $this->getItemMock('\App\Fake\Resources\Feed');

        $mockResource->shouldReceive('getRouteKey')->andReturn('Fake-UUID-Value-Not');

        $this->assertSame(config('app.url') . '/api/feeds/Fake-UUID-Value-Not', $mockResource->getUriAttribute());
    }

    public function testHidden()
    {
        /**
         * @var BaseResource $mockResource
         */
        $mockResource = new class() extends BaseResource {};

        $this->assertContains('_id', $mockResource->getHidden());
        $this->assertContains('updated_at', $mockResource->getHidden());
        $this->assertContains('created_at', $mockResource->getHidden());
    }

    public function testKeyTypeString()
    {
        /**
         * @var BaseResource $mockResource
         */
        $mockResource = new class() extends BaseResource {};

        $this->assertSame('string', $mockResource->getKeyType());
    }

    /**
     * @param string $name
     *
     * @return \Mockery\Mock|\App\Http\Resources\BaseResource
     */
    public function getItemMock(string $name)
    {
        return Mockery::namedMock($name, BaseResource::class)->makePartial();
    }
}
