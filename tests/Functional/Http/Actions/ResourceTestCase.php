<?php

namespace App\Tests\Functional\Http\Actions;

use App\Contracts\ResourceRoutable;
use App\Tests\TestCase;

/**
 * Class ResourceTestCase
 *
 * @package App\Tests\Functional\Http\Actions
 */
abstract class ResourceTestCase extends TestCase
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
     * @return \App\Contracts\ResourceRoutable|\App\Http\Resources\BaseResource
     */
    abstract public function getResourceInstance(): ResourceRoutable;
}
