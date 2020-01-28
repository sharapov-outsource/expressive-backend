<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 19.10.2019
 *     Time: 20:41
 */

namespace App\Entity\Datascope\Hydrator\Strategy;

use App\Entity\Datascope\DatascopeEntity;
use Laminas\Hydrator\Strategy\StrategyInterface;

use function method_exists;

/**
 * Class AccountStrategy
 */
class DatascopeStrategy implements StrategyInterface
{
    /**
     * @param mixed $value
     * @return null|array
     */
    public function extract($value, ?object $object = null)
    {
        if (! method_exists($object, 'getDatascope')) {
            return null;
        }

        /** @var DatascopeEntity $object */
        $object = $object->getDatascope();

        if ($object instanceof DatascopeEntity) {
            return [
                'id' => $object->getId(),
                'name' => $object->getDatascopeName(),
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
