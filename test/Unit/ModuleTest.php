<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Mail\Module;

class ModuleTest extends TestCase
{
    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('mail', $config);
        $this->assertArrayHasKey('transport', $config['mail']);
        $this->assertArrayHasKey('type', $config['mail']['transport']);
    }
}
