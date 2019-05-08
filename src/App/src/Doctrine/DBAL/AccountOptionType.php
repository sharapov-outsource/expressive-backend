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

use App\Entity\User\AccountOption;

class AccountOptionType extends EnumType
{
    protected $name = 'accountOptionType';
    protected $values
        = [
            AccountOption::OPTION_TYPE_PERSONAL,
            AccountOption::OPTION_TYPE_ADDRESS,
            AccountOption::OPTION_TYPE_CUSTOM
        ];
}
