<?php

namespace Integration;

use PHPUnit\Framework\TestCase;

class LaminasModuleTest extends TestCase
{
    /**
     * @return array
     */
    protected function getComposerConfig()
    {
        $composerFile = __DIR__ . '/../../composer.json';
        $this->assertFileExists($composerFile);
        $composerConfig = json_decode(file_get_contents($composerFile), true);
        $this->assertIsArray($composerConfig);
        return $composerConfig;
    }

    public function testModuleExists()
    {
        $composerConfig = $this->getComposerConfig();
        if (
            !isset($composerConfig['extra']['laminas'])
            || (
                empty($composerConfig['extra']['laminas']['component'])
                && empty($composerConfig['extra']['laminas']['module'])
            )
        ) {
            $this->markTestSkipped("No Laminas modules or components defined");
        }
        foreach (['component', 'module'] as $type) {
            if (array_key_exists($type, $composerConfig['extra']['laminas'])) {
                $classes = $composerConfig['extra']['laminas'][$type];
                if (!is_array($classes)) {
                    $classes = [$classes];
                }
                foreach ($classes as $class) {
                    $class = $class . '\\Module';
                    $this->assertTrue(class_exists($class), "Module class $class doesn't exist");
                }
            }
        }
    }
}
