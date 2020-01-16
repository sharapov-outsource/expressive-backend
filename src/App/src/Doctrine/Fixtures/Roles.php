<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 29.12.2019
 *     Time: 23:49
 */

namespace App\Doctrine\Fixtures;

use App\Entity\Account;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use function strtolower;
use function ucfirst;

class Roles implements FixtureInterface
{
    /**
     * @var array
     */
    public $roles = [
        Account\AccountRoleEntity::DEFAULT_ROLE_ADMIN,
        Account\AccountRoleEntity::DEFAULT_ROLE_DEVELOPER,
        Account\AccountRoleEntity::DEFAULT_ROLE_MODERATOR,
        Account\AccountRoleEntity::DEFAULT_ROLE_USER,
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->roles as $role) {
            $role = strtolower($role);
            $userAccountRole = new Account\AccountRoleEntity();
            $userAccountRole
                ->setKey($role)
                ->setTitle(ucfirst($role))
                ->setStatus(true);
            $manager->persist($userAccountRole);
        }
        $manager->flush();
    }
}
