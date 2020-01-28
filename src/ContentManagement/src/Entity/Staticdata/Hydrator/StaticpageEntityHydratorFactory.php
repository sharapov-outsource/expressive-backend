<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 18.10.2019
 *     Time: 23:27
 */

namespace ContentManagement\Entity\Staticdata\Hydrator;

use App\Doctrine\Hydrator\DoctrineObject;
use App\Entity\Account\Hydrator\Strategy\AccountStrategy;
use App\Entity\Datascope\Hydrator\Strategy\DatascopeStrategy;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Hydrator for Doctrine Entity
 */
class StaticpageEntityHydratorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param $options array|null
     * @return object|DoctrineObject
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_app');
        $hydrator = new DoctrineObject($entityManager);
        $hydrator->addStrategy(
            'account',
            new AccountStrategy()
        );
        $hydrator->addStrategy(
            'datascope',
            new DatascopeStrategy()
        );
        return $hydrator;
    }
}
