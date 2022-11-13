<?php

namespace AhmetBarut\Documentor\Tests;

use AhmetBarut\Documentor\Providers\AhmetBarutLaravelDocumentorProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            AhmetBarutLaravelDocumentorProvider::class,
        ];
    }
}
