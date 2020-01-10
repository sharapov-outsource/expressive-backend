<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 18.10.2019
 *     Time: 23:27
 */

namespace App\Entity\Account\Hydrator;

use App\Doctrine\Hydrator\DoctrineObject;
use Interop\Container\ContainerInterface;
use Laminas\Hydrator\Filter\FilterComposite;
use Laminas\ServiceManager\Factory\FactoryInterface;

use function in_array;

/**
 * Hydrator for Doctrine Entity
 */
class AccountEntityHydratorFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
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
            'accountRole',
            new Strategy\AccountRoleStrategy()
        );
        $hydrator->addStrategy(
            'accountOption',
            new Strategy\AccountOptionStrategy()
        );
        $hydrator->addFilter('exclude', static function ($property) {
            if (in_array($property, ['activateToken', 'password'])) {
                return false;
            }

            return true;
        }, FilterComposite::CONDITION_AND);
        return $hydrator;
    }
}
