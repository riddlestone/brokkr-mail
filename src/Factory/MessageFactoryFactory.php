<?php

namespace Riddlestone\Brokkr\Mail\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplatePathStack;
use Laminas\View\View;
use Laminas\View\ViewEvent;
use Riddlestone\Brokkr\Mail\MessageFactory;

class MessageFactoryFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MessageFactory($this->getView($container));
    }

    /**
     * @param ContainerInterface $container
     * @return View
     */
    protected function getView($container)
    {
        $templateResolver = new TemplatePathStack(
            [
                'script_paths' => $container->get('Config')['view_manager']['template_path_stack'],
            ]
        );
        $renderer = new PhpRenderer();
        $renderer->setResolver($templateResolver);

        // Initialize the view
        $view = new View();
        $view->getEventManager()->attach(
            ViewEvent::EVENT_RENDERER,
            static function () use ($renderer) {
                return $renderer;
            }
        );

        return $view;
    }
}
