<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

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

    public function testHelloWorld()
    {
        $this->get('/hello');

        $this->assertEquals(
            "Hello World!", $this->response->getContent()
        );
    }

    public function testRssDefault() {
        $this->get('/rss-test');

        $content = 'NASA Breaking News, http://www.nasa.gov/, A RSS news feed containing the latest NASA news articles and press releases.';

        $this->assertEquals(
            $content, $this->response->getContent()
        );
    }

    public function testRssTest() {
        $this->get('/rss-test?url=https://abcnews.go.com/abcnews/topstories');

        $content = 'ABC News: Top Stories, http://abcnews.go.com/';

        $this->assertEquals(
            $content, $this->response->getContent()
        );
    }
}
