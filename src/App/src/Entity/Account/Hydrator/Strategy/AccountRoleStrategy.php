<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 19.10.2019
 *     Time: 20:41
 */

namespace App\Entity\Account\Hydrator\Strategy;

use App\Entity\Account\AccountEntity;
use App\Entity\Account\AccountRoleEntity;
use Laminas\Hydrator\Strategy\StrategyInterface;

/**
 * Class AccountRoleStrategy
 */
class AccountRoleStrategy implements StrategyInterface
{
    /**
     * @param mixed $value
     * @return null|array
     */
    public function extract($value, ?object $object = null)
    {
        /** @var AccountEntity $object */
        if ($object->getAccountRole() instanceof AccountRoleEntity) {
            return [
                'id' => $object->getAccountRole()->getId(),
                'title' => $object->getAccountRole()->getTitle(),
                'key' => $object->getAccountRole()->getKey(),
                'status' => $object->getAccountRole()->getStatus(),
                'dateCreated' => $object->getAccountRole()->getDateCreated(),
                'dateUpdated' => $object->getAccountRole()->getDateUpdated(),
            ];
        }
        return null;
    }

    /**
     * @param mixed $value
     * @param array|null $data
     * @return mixed
     */
    public function hydrate($value, ?array $data = null)
    {
        return $value;
    }
}
