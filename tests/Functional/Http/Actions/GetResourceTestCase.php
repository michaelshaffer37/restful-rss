<?php

namespace App\Tests\Functional\Http\Actions;

use App\Tests\TestCase;

/**
 * Class GetResourceTestCase
 *
 * @package App\Tests\Functional\Http\Actions
 */
abstract class GetResourceTestCase extends TestCase
{
    /**
     * Returns the path to the resource collection
     *
     * e.g. 'api/sources'
     *
     * @return string
     */
    abstract public function getResourcePath(): string;

    /**
     * Request that asks for JSON should get json.
     *
     * @return void
     */
    public function testNotFoundResource()
    {
        // Note this is a version 4 uuid
        $this->get(
            trim($this->getResourcePath(), '/') . '/a5a2fb8f-6b10-4148-b491-7c6b388b152e',
            ['Accept' => 'application/json']
        );

        $this->assertResponseStatus(404);

        $this->receiveJson(
            ['msg' => 'Not Found']
        );
    }
}
