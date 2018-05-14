<?php

namespace App\Tests;

use App\Support\Json;
use Exception;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;
use Mockery;

/**
 * Class TestCase
 *
 * @package App\Tests
 */
abstract class TestCase extends LumenTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    /**
     * Run a Post of a Json Payload through the application
     *
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return $this
     */
    public function postJson(string $uri, array $data = [], array $headers = [])
    {
        $headers = array_merge(
            $headers,
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        );

        $server = $this->transformHeadersToServerVars($headers);

        $this->call('POST', $uri, [], [], [], $server, Json::encode($data));

        return $this;
    }

    /**
     * Run a Get Request with Json Accept headers
     *
     * @param string $uri
     * @param array  $headers
     */
    public function getJson(string $uri, array $headers = [])
    {
        $this->get($uri, array_merge($headers, ['Accept' => 'application/json']));
    }

    /**
     * Mock the event dispatcher so all events are errors.
     *
     * @return $this
     */
    protected function expectNoEvents()
    {
        $mock = Mockery::mock('Illuminate\Contracts\Events\Dispatcher');

        $mock->shouldReceive('fire')->andReturnUsing(function ($called) {
            throw new Exception(
                'The following event was fired: ' . $called
            );
        });

        $this->app->instance('events', $mock);

        return $this;
    }
}
