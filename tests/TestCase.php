<?php

namespace App\Tests;

use App\Support\Json;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;

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
    protected function postJson(string $uri, array $data = [], array $headers = [])
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
}
