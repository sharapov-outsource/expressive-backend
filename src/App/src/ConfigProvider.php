<?php

declare(strict_types=1);

namespace App;

use App\Doctrine\DoctrineArrayCacheFactory;
use App\Doctrine\DoctrineFactory;
use Doctrine\Common\Cache\Cache as DoctrineCache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getEntities()
        ];
    }

    /**
     * Returns the container dependencies
     */
    private function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                'doctrine.entitymanager.orm_default' => DoctrineFactory::class,
                DoctrineCache::class                 => DoctrineArrayCacheFactory::class,
                Handler\HomePageHandler::class       => Handler\HomePageHandlerFactory::class,
                Handler\DbTestHandler::class         => Handler\DbTestHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the container entities
     */
    private function getEntities(): array
    {
        return [
            'driver'     => [
                'entity_driver'  => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity']
                ],
                'orm_default'    => [
                    'class'   => MappingDriverChain::class,
                    'drivers' => [
                        'App\src\Entity' => 'entity_driver'
                    ],
                ],
                'proxyDir'       => 'etc/data/EntityProxy',
                'proxyNamespace' => 'EntityProxy'
            ],
            'connection' => [
                'orm_default' => [
                    'doctrine_type_mappings' => [
                        'enum' => 'string'
                    ],
                    'params'                 => [
                        'driverClass' => Driver::class,
                    ]
                ]
            ]
        ];
    }
}
