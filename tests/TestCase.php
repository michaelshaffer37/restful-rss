<?php

namespace App\Tests;

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
        return require __DIR__.'/../bootstrap/app.php';
    }
}
