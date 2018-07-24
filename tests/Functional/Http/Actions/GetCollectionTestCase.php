<?php

namespace App\Tests\Functional\Http\Actions;

use App\Support\Json;

/**
 * Class GetCollectionTestCase
 *
 * @package App\Tests\Functional\Http\Actions
 */
abstract class GetCollectionTestCase extends ResourceTestCase
{
    public function testSuccessfulGet()
    {
        $resource = $this->getResourceInstance();

        $this->getJson(
            route($resource->getCollectionName())
        );

        $this->assertSuccessfulCollectionRequest();
    }


    public function testSuccessfulGetWithOutHeaders()
    {
        $resource = $this->getResourceInstance();

        $this->get(
            route($resource->getCollectionName())
        );

        $this->assertSuccessfulCollectionRequest();
    }

    public function assertSuccessfulCollectionRequest()
    {
        $this->assertResponseStatus(200);
        $this->assertHasHeaders('Content-Type', 'application/json');

        $this->receiveJson();

        $content = Json::decode($this->response->getContent());

        $this->assertTrue(is_array($content));
    }
}
