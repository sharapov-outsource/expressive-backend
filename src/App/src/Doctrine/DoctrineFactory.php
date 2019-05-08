<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 23:00
 */

declare(strict_types=1);

namespace App\Doctrine;

use Adbar\Dot;
use App\Doctrine\DBAL\AccountOptionType;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\Cache as DoctrineCache;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type as DBALtype;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\ORMException;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Exception\RuntimeException;

/**
 * Class DoctrineFactory
 *
 * @package App\Doctrine
 */
class DoctrineFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return EntityManager
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container): EntityManager
    {
        if (!$container->has('config')) {
            throw new RuntimeException('No configuration files provided');
        }
        /** @var Dot $config */
        $config = $container->get('dotConfig');

        // Register abstract layer types
        $this->registerDBAL();

        // Doctrine ORM
        $doctrine = new Configuration();
        $doctrine->setProxyDir($config->get('doctrine.driver.proxyDir'));
        $doctrine->setProxyNamespace($config->get('doctrine.driver.proxyNamespace'));
        $doctrine->setAutoGenerateProxyClasses(true);

        // ORM mapping by Annotation
        AnnotationRegistry::registerFile(
            'vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );

        $doctrine->setMetadataDriverImpl(
            AnnotationDriver::create($config->get('doctrine.driver.entity_driver.paths'))
        );
        // Cache
        $cache = $container->get(DoctrineCache::class);
        $doctrine->setQueryCacheImpl($cache);
        $doctrine->setResultCacheImpl($cache);
        $doctrine->setMetadataCacheImpl($cache);

        // EntityManager
        $em = EntityManager::create(
            $config->get('doctrine.connection.orm_app.params'),
            $doctrine
        );

        try {
            if ($config->has('doctrine.connection.orm_app.doctrine_type_mappings')) {
                $dbPlatform = $em
                    ->getConnection()
                    ->getSchemaManager()
                    ->getDatabasePlatform();
                foreach ($config->get('doctrine.connection.orm_app.doctrine_type_mappings')
                as
                    $dbType => $doctrineType) {
                    $dbPlatform
                        ->registerDoctrineTypeMapping($dbType, $doctrineType);
                }
            }
        } catch (DBALException $e) {
            throw new ORMException($e->getMessage());
        }
        return $em;
    }

    /**
     * Register abstract layer types
     *
     * @throws ORMException
     */
    private function registerDBAL(): void
    {
        try {
            DBALtype::addType('accountOptionType', AccountOptionType::class);
        } catch (DBALException $e) {
            throw new ORMException($e->getMessage());
        }
    }
}
