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

use App\Doctrine\Hydrator\Strategy\AbstractCollectionStrategy;
use App\Entity\Account\AccountOptionEntity;

/**
 * Class AccountOptionStrategy
 */
class AccountOptionStrategy extends AbstractCollectionStrategy
{
    /**
     * @param mixed $value
     * @return array
     */
    public function extract($value, ?object $object = null)
    {
        $this->setObject($object);
        $accountOptions = [];

        foreach ($this->getCollectionFromObjectByValue() as $accountOptionEntity) {
            /** @var AccountOptionEntity $accountOptionEntity */
            $accountOptions[] = [
                'id' => $accountOptionEntity->getId(),
                'type' => $accountOptionEntity->getOptionTypeKey(),
                'key' => $accountOptionEntity->getOptionKey(),
                'value' => $accountOptionEntity->getOptionValue(),
                'isRequired' => $accountOptionEntity->getIsRequired(),
                'isReadonly' => $accountOptionEntity->getReadOnly(),
            ];
        }

        unset($accountOptionEntity);

        return $accountOptions;
    }

    /**
     * @param mixed $value
     * @param null|array $data
     * @return mixed
     */
    public function hydrate($value, ?array $data = null)
    {
        return $value;
    }
}
