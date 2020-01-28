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
use Laminas\Hydrator\Strategy\StrategyInterface;

use function method_exists;

/**
 * Class AccountStrategy
 */
class AccountStrategy implements StrategyInterface
{
    /**
     * @param mixed $value
     * @return null|array
     */
    public function extract($value, ?object $object = null)
    {
        if (! method_exists($object, 'getAccount')) {
            return null;
        }

        /** @var AccountEntity $object */
        $object = $object->getAccount();

        if ($object instanceof AccountEntity) {
            return [
                'id' => $object->getId(),
                'username' => $object->getUsername(),
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
