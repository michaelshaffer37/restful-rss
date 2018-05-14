<?php

namespace App\Tests\Functional\Http\Actions;

use App\Tests\TestCase;

/**
 * Class IndexActionTest
 *
 * A Set of initial example tests to be run on the app.
 */
class IndexActionTest extends TestCase
{
    /**
     * A basic application health check.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/');

        $this->assertTrue($this->response->isOk());

        $this->receiveJson(
            ['version' => $this->app->version()]
        );
    }

    /**
     * Test sending a bad method to endpoint.
     *
     * @return void
     */
    public function testBadMethod()
    {
        $this->post('/', [], ['Accept' => 'application/json']);

        $this->receiveJson();

        $this->assertTrue(
            $this->response->isClientError()
        );
    }

    /**
     * Test requesting an invalid endpoint.
     *
     * @return void
     */
    public function testInvalidEndpoint()
    {
        $this->get('/api', ['Accept' => 'application/json']);

        $this->assertTrue(
            $this->response->isNotFound()
        );

        $this->receiveJson();
    }
}
