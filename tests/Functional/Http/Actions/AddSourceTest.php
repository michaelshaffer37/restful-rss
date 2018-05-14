<?php

namespace App\Tests\Functional\Http\Actions;

use App\Http\Resources\Source;
use App\Tests\TestCase;

/**
 * Class AddSourceTest
 *
 * @package App\Tests\Functional\Http\Actions
 */
class AddSourceTest extends TestCase
{
    public function testCreateResource()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            [
                'name' => 'Test Feed',
                'url' => 'https://www.wired.com/feed/category/science/latest/rss',
            ]
        );

        $this->assertResponseStatus(200);

        $this->receiveJson(
            [
                'name' => 'Test Feed',
                'url' => 'https://www.wired.com/feed/category/science/latest/rss',
                'status' => 'QUEUED',
                'uri' => 'http://localhost:8181/api/sources/5c870759-2fc9-5225-83bf-ba3d81767101',
            ]
        );

        Source::destroy(['5c870759-2fc9-5225-83bf-ba3d81767101']);
    }

    public function test422OnNoUrl()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            ['name' => 'Test Feed']
        );

        $this->assertResponseStatus(422);

        $this->receiveJson(
            ['msg' => 'Unprocessable Entity']
        );
    }

    public function test422OnNoName()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            ['url' => 'https://www.wired.com/feed/category/science/latest/rss']
        );

        $this->assertResponseStatus(422);

        $this->receiveJson(
            ['msg' => 'Unprocessable Entity']
        );
    }

    public function test422OnLongName()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            [
                'name' => str_pad('', 65, 'T'),
                'url' => 'https://www.wired.com/feed/category/science/latest/rss'
            ]
        );

        $this->assertResponseStatus(422);

        $this->receiveJson(
            ['msg' => 'Unprocessable Entity']
        );
    }

    public function test422OnNonStringName()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            [
                'name' => null,
                'url' => 'https://www.wired.com/feed/category/science/latest/rss'
            ]
        );

        $this->assertResponseStatus(422);

        $this->receiveJson(
            ['msg' => 'Unprocessable Entity']
        );
    }

    public function test422OnInvalidUrl()
    {
        $this->withoutEvents();

        $this->postJson(
            '/api/sources',
            [
                'name' => 'Test Feed',
                'url' => 'this is not a valid url'
            ]
        );

        $this->assertResponseStatus(422);

        $this->receiveJson(
            ['msg' => 'Unprocessable Entity']
        );
    }
}
