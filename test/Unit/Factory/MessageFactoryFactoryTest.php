<?php

namespace Riddlestone\Brokkr\Mail\Test\Unit\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\View\View;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Mail\Factory\MessageFactoryFactory;
use Riddlestone\Brokkr\Mail\MessageFactory;

class MessageFactoryFactoryTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testInvokeSuccess()
    {
        $config = [
            'view_manager' => [
                'template_path_stack' => [
                    'first_dir',
                    'second/dir',
                ],
            ],
        ];
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with('Config')->willReturn($config);

        $factory = new MessageFactoryFactory();
        $messageFactory = $factory($container, 'Anything');
        $this->assertInstanceOf(MessageFactory::class, $messageFactory);
        $this->assertInstanceOf(View::class, $messageFactory->getView());
    }
}
