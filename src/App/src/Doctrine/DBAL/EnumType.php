<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-29
 *     Time: 13:46
 */

namespace App\Doctrine\DBAL;

use Doctrine\DBAL;
use InvalidArgumentException;

use function array_map;
use function implode;
use function in_array;

abstract class EnumType extends DBAL\Types\Type
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * Get sql query part for ENUM types
     *
     * @param array $fieldDeclaration
     * @param DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration,
        DBAL\Platforms\AbstractPlatform $platform
    ) : string {
        $values = array_map(static function ($val) {
            return "'" . $val . "'";
        }, $this->values);

        return 'ENUM(' . implode(', ', $values) . ") COMMENT '(DC2Type:"
            . $this->name . ")'";
    }

    /**
     * @param mixed $value
     * @param DBAL\Platforms\AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue(
        $value,
        DBAL\Platforms\AbstractPlatform $platform
    ) {
        return $value;
    }

    /**
     * @param mixed $value
     * @param DBAL\Platforms\AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue(
        $value,
        DBAL\Platforms\AbstractPlatform $platform
    ) {
        if (! in_array($value, $this->values)) {
            throw new InvalidArgumentException(
                "Invalid '" . $this->name
                . "' value."
            );
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
