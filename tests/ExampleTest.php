<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class ExampleTest
 *
 * A Set of initial example tests to be run on the app.
 */
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    /**
     * Simple Functional Test
     *
     * @return void
     */
    public function testHelloWorld()
    {
        $this->get('/hello');

        $this->assertEquals(
            "Hello World!", $this->response->getContent()
        );
    }

    /**
     * Simple Test of POC RSS Parsing End-point
     *
     * @return void
     */
    public function testRssDefault() {
        $this->get('/rss-test');

        $content = 'NASA Breaking News, http://www.nasa.gov/, A RSS news feed containing the latest NASA news articles and press releases.';

        $this->assertEquals(
            $content, $this->response->getContent()
        );
    }

    /**
     * Simple test of POS RSS Parsing end-point, passing a url
     *
     * @return void
     */
    public function testRssTest() {
        $this->get('/rss-test?url=https://abcnews.go.com/abcnews/topstories');

        $content = 'ABC News: Top Stories, http://abcnews.go.com/';

        $this->assertEquals(
            $content, $this->response->getContent()
        );
    }
}
