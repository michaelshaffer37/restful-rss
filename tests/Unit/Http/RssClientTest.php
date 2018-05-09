<?php

namespace App\Tests\Unit\Http;

use App\Http\RssClient;
use App\Tests\TestCase;
use Zend\Feed\Reader\Http\ClientInterface;

/**
 * Class GuzzleClientTest
 *
 * @package App\Tests\Unit
 */
class GuzzleClientTest extends TestCase
{
    /**
     * A test that verifies that the RSS client Implements the Zend Reader Http Client Interface.
     *
     * @return void
     */
    public function testInterface()
    {
        $client = new RssClient();

        $this->assertTrue(
            $client instanceof ClientInterface,
            'The RssClient should implement the Zend Reader Http Interface.'
        );
    }
}
