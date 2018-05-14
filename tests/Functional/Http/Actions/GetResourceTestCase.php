<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Http\Resources\BaseResource;
use App\Tests\TestCase;

/**
 * Class GetResourceTestCase
 *
 * @package App\Tests\Functional\Http\Actions
 */
abstract class GetResourceTestCase extends TestCase
{
    /**
     * Note this is a v4 uuid so it will never collide with real app data.
     */
    const NON_APP_UUID = 'a5a2fb8f-6b10-4148-b491-7c6b388b152e';

    /**
     * Clean Up after the tests.
     */
    public function tearDown()
    {
        $this->getResourceInstance()->destroy([static::NON_APP_UUID]);
        parent::tearDown();
    }

    /**
     * Get a new instance of the resource for tests.
     *
     * @return BaseResource
     */
    abstract public function getResourceInstance(): ResourceRoutable;

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
