<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-29
 * Time: 13:46
 */

declare(strict_types=1);

namespace App\Doctrine\DBAL;

use Doctrine\DBAL;

abstract class EnumType extends DBAL\Types\Type
{
    protected $name;
    protected $values = [];

    public function getSQLDeclaration(
        array $fieldDeclaration,
        DBAL\Platforms\AbstractPlatform $platform
    ) {
        $values = array_map(function ($val) {
            return "'" . $val . "'";
        }, $this->values);

        return "ENUM(" . implode(", ", $values) . ") COMMENT '(DC2Type:"
            . $this->name . ")'";
    }

    public function convertToPHPValue(
        $value,
        DBAL\Platforms\AbstractPlatform $platform
    ) {
        return $value;
    }

    public function convertToDatabaseValue(
        $value,
        DBAL\Platforms\AbstractPlatform $platform
    ) {
        if (!in_array($value, $this->values)) {
            throw new \InvalidArgumentException("Invalid '" . $this->name
                . "' value.");
        }

        return $value;
    }

    public function getName()
    {
        return $this->name;
    }
}
