<?php

declare(strict_types=1);

namespace App;

use App\Doctrine\DoctrineArrayCacheFactory;
use App\Doctrine\DoctrineFactory;
use App\Entity\Account\AccountEntity;
use App\Entity\Account\Hydrator\AccountEntityHydratorFactory;
use App\Handler\HalResource\Account\AccountCollection;
use App\Library\ArrayDotAccess;
use App\Library\ArrayDotAccessFactory;
use Doctrine\Common\Cache\Cache as DoctrineCache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

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
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => $this->getEntities(),
            MetadataMap::class => $this->getHalConfig(),
            'hydrators' => [
                'factories' => [
                    AccountEntityHydratorFactory::class => AccountEntityHydratorFactory::class,
                ],
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    private function getDependencies() : array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories' => [
                // Doctrine factories
                'doctrine.entitymanager.orm_app'
                => DoctrineFactory::class,
                DoctrineCache::class
                => DoctrineArrayCacheFactory::class,
                // Documentation
                Doc\InvalidParameterHandler::class => InvokableFactory::class,
                Doc\MethodNotAllowedHandler::class => InvokableFactory::class,
                Doc\OutOfBoundsHandler::class => InvokableFactory::class,
                Doc\ResourceNotFoundHandler::class => InvokableFactory::class,
                Doc\RuntimeErrorHandler::class => InvokableFactory::class,
                // Main handlers
                Handler\HomePageHandler::class
                => Handler\HomePageHandlerFactory::class,
                Handler\DbTestHandler::class
                => Handler\DbTestHandlerFactory::class,
                // Hal resources
                Handler\HalResource\Account\AccountHandler::class
                => Handler\HalResource\Account\AccountHandlerFactory::class,

                // Service resources
                ArrayDotAccess::class => ArrayDotAccessFactory::class,
            ],
        ];
    }

    /**
     * Returns the container entities
     */
    private function getEntities() : array
    {
        return [
            'driver' => [
                'entity_driver' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
                'orm_app' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'App\src\Entity' => 'entity_driver',
                    ],
                ],
                'proxyDir' => 'etc/data/EntityProxy',
                'proxyNamespace' => 'EntityProxy',
            ],
            'connection' => [
                'orm_app' => [
                    'doctrine_type_mappings' => [
                        'enum' => 'string',
                    ],
                    'params' => [
                        'driverClass' => Driver::class,
                    ],
                ],
            ],
        ];
    }

    /**
     * Returns HAL configuration
     */
    public function getHalConfig() : array
    {
        return [
            [
                '__class__' => RouteBasedResourceMetadata::class,
                'resource_class' => AccountEntity::class,
                'route' => 'api.accounts.get',
                'extractor' => AccountEntityHydratorFactory::class,
                //ReflectionHydrator::class,
                //ObjectPropertyHydrator::class

                //'hydrator' => 'User\\Hydrator\\UserProfile',
            ],
            [
                '__class__' => RouteBasedCollectionMetadata::class,
                'collection_class' => AccountCollection::class,
                'collection_relation' => 'Account',
                'route' => 'api.accounts.get',
            ],
            /*
            [
                '__class__'      => RouteBasedResourceMetadata::class,
                'resource_class' => Entity\SiteStatistic::class,
                'route'          => 'api.statistics',
                'extractor'      => ReflectionHydrator::class,
            ],
            [
                '__class__'           => RouteBasedCollectionMetadata::class,
                'collection_class'    => Site\StatisticCollection::class,
                'collection_relation' => 'statistics',
                'route'               => 'api.statistics',
            ]*/
        ];
    }
}
