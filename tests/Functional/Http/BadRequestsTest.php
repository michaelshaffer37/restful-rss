<?php

namespace App\Tests\Functional\Http;

use App\Tests\TestCase;

/**
 * Class BadRequestsTest
 *
 * @package App\Tests\Functional\Http
 */
class BadRequestsTest extends TestCase
{
    /**
     * Request that asks non existent resources should get 404 & json.
     *
     * @return void
     */
    public function test404GivesJsonDefault()
    {
        $this->get('/this/random/url/does/not/exist', ['Accept' => '*']);

        $this->assertTrue($this->response->isNotFound());

        $this->receiveJson(
            ['msg' => 'Not Found']
        );
    }

    /**
     * Request that asks for JSON should get json.
     *
     * @return void
     */
    public function test404GivesJson()
    {
        $this->get('/this/random/url/does/not/exist', ['Accept' => 'application/json']);

        $this->assertTrue($this->response->isNotFound());

        $this->receiveJson(
            ['msg' => 'Not Found']
        );
    }
}
