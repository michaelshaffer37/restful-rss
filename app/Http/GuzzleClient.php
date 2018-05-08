<?php

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Zend\Feed\Reader\Http\ClientInterface as FeedReaderHttpClientInterface;
use Zend\Feed\Reader\Http\Psr7ResponseDecorator;

/**
 * Class GuzzleClient
 *
 * A GuzzleClient that implements the FeedReaderHttpClient Interface and uses a PSR-7 client.
 *
 * @package App\Http
 */
class GuzzleClient implements FeedReaderHttpClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $client;

    /**
     * @param GuzzleClientInterface|null $client
     */
    public function __construct(GuzzleClientInterface $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri)
    {
        return new Psr7ResponseDecorator(
            $this->client->request('GET', $uri)
        );
    }
}
