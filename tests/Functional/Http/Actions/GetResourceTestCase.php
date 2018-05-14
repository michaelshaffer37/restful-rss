<?php

namespace App\Tests\Functional\Http\Actions;

/**
 * Class GetResourceTestCase
 *
 * @package App\Tests\Functional\Http\Actions
 */
abstract class GetResourceTestCase extends ResourceTestCase
{
    /**
     * Request that asks for JSON should get json.
     *
     * @return void
     */
    public function testNotFoundResource()
    {
        $resource = $this->getResourceInstance();

        // Note this is a version 4 uuid
        $this->get(
            route($resource->getRouteName(), [$resource->getRouteKeyName() => static::NON_APP_UUID]),
            ['Accept' => 'application/json']
        );

        $this->assertResponseStatus(404);

        $this->receiveJson(
            ['msg' => 'Not Found']
        );
    }

    /**
     * Request that asks for JSON should get json.
     *
     * @return void
     */
    public function testSuccessGetResource()
    {
        $this->withoutEvents();

        $resource = $this->getResourceInstance();
        $resource->fill([
            '_id' => static::NON_APP_UUID,
        ]);

        // Persis the Resource for this test.
        $resource->save();

        $uri = route(
            $resource->getRouteName(),
            [
                $resource->getRouteKeyName() => static::NON_APP_UUID
            ]
        );

        // Note this is a version 4 uuid
        $this->getJson($uri);

        $this->assertResponseStatus(200);

        $this->receiveJson(
            ['uri' => $uri]
        );
    }
}
