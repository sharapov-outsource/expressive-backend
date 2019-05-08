<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-05-07
 * Time: 22:31
 */

declare(strict_types=1);

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

use App\Doctrine\DoctrineFactory;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\ORMException;

class InitDB implements FixtureInterface
{
    public $roles
        = [
            User\AccountRoleEntity::DEFAULT_ROLE_DEVELOPER,
            User\AccountRoleEntity::DEFAULT_ROLE_MODERATOR,
            User\AccountRoleEntity::DEFAULT_ROLE_USER
        ];

    public $default_username = 'admin';
    public $default_userpass = 'admin@password';

    public function load(ObjectManager $manager)
    {
        // Check if admin role exists

        $userAccountRoleAdmin = new User\AccountRoleEntity();
        $userAccountRoleAdmin
            ->setKey(User\AccountRoleEntity::DEFAULT_ROLE_ADMIN)
            ->setTitle('Administrator')
            ->setStatus(1);
        //$manager->persist($userAccountRoleAdmin);
        //$manager->flush();

        // Check if admin user exists
        $userAccountAdmin = new User\AccountEntity();
        $userAccountAdmin
            ->setUsername($this->default_username)
            ->setPassword(md5($this->default_userpass))
            ->setStatus(1)
            ->setIsActivated(1)
            ->setAccountRole($userAccountRoleAdmin);
        $manager->persist($userAccountAdmin);
        $manager->flush();

        unset($userAccountRoleAdmin, $userAccountAdmin);
        // Check if other default roles are exists
        // Developer, moderator and user
        foreach ($this->roles as $role) {
            $userAccountRole = new User\AccountRoleEntity();
            $userAccountRole
                ->setKey($role)
                ->setTitle(ucfirst($role))
                ->setStatus(1);
            $manager->persist($userAccountRole);
            $manager->flush();
            unset($userAccountRole);

        }
    }
}

// Doctrine connection configuration
try {
    $loader = new Loader();
    $loader->addFixture(new InitDB());
    $entityManager = (new DoctrineFactory)(require 'config/container.php');

    $executor
        = new ORMExecutor($entityManager, new ORMPurger());
    $executor->execute($loader->getFixtures());

    printf(
        "Database fixtures has been loaded%s",
        PHP_EOL
    );
    exit(0);
} catch (ORMException $e) {
    throw new \RuntimeException($e->getMessage());
}
