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

use App\Entity\Account\AccountOptionEntity;

class AccountOptionType extends EnumType
{
    protected $name = 'accountOptionType';
    protected $values
    = [
        AccountOptionEntity::OPTION_TYPE_PERSONAL,
        AccountOptionEntity::OPTION_TYPE_ADDRESS,
        AccountOptionEntity::OPTION_TYPE_CUSTOM,
    ];
}
