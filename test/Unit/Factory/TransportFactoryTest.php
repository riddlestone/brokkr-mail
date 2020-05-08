<?php

namespace Riddlestone\Brokkr\Mail\Test\Unit;

use Interop\Container\ContainerInterface;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Mail\Factory\TransportFactory;

class TransportFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $factory = new TransportFactory();

        $transport = $this->createMock(TransportInterface::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturn(
            [
                'mail' => [
                    'transport' => [
                        'type' => get_class($transport),
                    ],
                ],
            ]
        );
        $this->assertInstanceOf(get_class($transport), $factory($container, TransportInterface::class));
    }

    public function testBadInvoke()
    {
        $factory = new TransportFactory();

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturn(
            [
                'mail' => [
                    'transport' => [
                        'type' => 'invalid-class',
                    ],
                ],
            ]
        );
        $this->expectException(ServiceNotCreatedException::class);
        $factory($container, TransportInterface::class);
    }
}
