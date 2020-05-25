<?php

namespace Riddlestone\Brokkr\Mail\Test\Integration;

use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

abstract class AbstractApplicationTestCase extends TestCase
{
    /**
     * @var Application
     */
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();

        $appConfig = require __DIR__ . '/config/application.config.php';
        $this->app = Application::init($appConfig);
    }
}
