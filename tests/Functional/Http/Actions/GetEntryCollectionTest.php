<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\Entry;

/**
 * Class GetSourceCollectionTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class GetEntryCollectionTest extends GetCollectionTestCase
{
    /**
     * @return \App\Contracts\ResourceRoutable
     */
    public function getResourceInstance(): ResourceRoutable
    {
        return new Entry();
    }

    public function testQueryByDate()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['date' => '2018-05-05'])
        );

        $this->assertSuccessfulCollectionRequest();
    }

    public function testQueryByString()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['search' => 'test foo'])
        );

        $this->assertSuccessfulCollectionRequest();
    }

    public function testInvalidQueryDate1()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['date' => '2018-5-5'])
        );

        $this->assertResponseStatus(422);
        $this->assertHasHeaders('Content-Type', 'application/json');
        $this->receiveJson();
    }

    public function testInvalidQueryDate2()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['date' => '18-05-05'])
        );

        $this->assertResponseStatus(422);
        $this->assertHasHeaders('Content-Type', 'application/json');
        $this->receiveJson();
    }

    public function testInvalidStringQuery1()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['search' => 'test$%'])
        );

        $this->assertResponseStatus(422);
        $this->assertHasHeaders('Content-Type', 'application/json');
        $this->receiveJson();
    }

    public function testInvalidStringQuery2()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['search' => 'in'])
        );

        $this->assertResponseStatus(422);
        $this->assertHasHeaders('Content-Type', 'application/json');
        $this->receiveJson();
    }

    public function testInvalidQueryBothParams()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName(), ['search' => 'test', 'date' => '2018-05-05'])
        );

        $this->assertResponseStatus(422);
        $this->assertHasHeaders('Content-Type', 'application/json');
        $this->receiveJson();
    }
}
