<?php

declare(strict_types=1);

namespace ContentManagement;

use ContentManagement\Entity\Staticdata\Hydrator\StaticpageEntityHydratorFactory;
use ContentManagement\Entity\Staticdata\StaticpageEntity;
use ContentManagement\Handler\HalResource\Staticdata;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Hydrator\ReflectionHydrator;
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
                    StaticpageEntityHydratorFactory::class => StaticpageEntityHydratorFactory::class,
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
            'factories' => [
                // Main handlers

                // Hal resources
                Staticdata\StaticpageHandler::class => Staticdata\StaticpageHandlerFactory::class,
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
                    'paths' => [__DIR__ . '/Entity'],
                ],
                'orm_app' => [
                    'drivers' => [
                        'ContentManagement\src\Entity' => 'entity_driver',
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
                'resource_class' => StaticpageEntity::class,
                'route' => 'api.staticpages.get',
                'extractor' => StaticpageEntityHydratorFactory::class,
            ],
            [
                '__class__' => RouteBasedCollectionMetadata::class,
                'collection_class' => Staticdata\StaticpageCollection::class,
                'collection_relation' => 'Staticpage',
                'route' => 'api.staticpages.get',
            ],
        ];
    }
}
