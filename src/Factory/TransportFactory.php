<?php

namespace Riddlestone\Brokkr\Mail\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Mail\Transport\Factory;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Throwable;

class TransportFactory implements FactoryInterface
{
    /**
     * Create a mail transport
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return TransportInterface
     * @throws ServiceNotCreatedException if an exception is raised when creating a service.
     * @SuppressWarnings(PHPMD.StaticAccess) - This factory wraps the static factory to isolate the static dependency
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        try {
            return Factory::create($container->get('Config')['mail']['transport']);
        } catch (Throwable $e) {
            throw new ServiceNotCreatedException($e->getMessage(), 0, $e);
        }
    }
}
