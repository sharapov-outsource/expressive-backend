<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;

class DbTestHandlerFactory
{
    public function __invoke(
        ContainerInterface $container
    ): RequestHandlerInterface {
        return new DbTestHandler(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get(RouterInterface::class)
        );
    }
}
