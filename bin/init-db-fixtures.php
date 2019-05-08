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

ini_set('display_errors', '1');

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
            User\AccountRole::DEFAULT_ROLE_DEVELOPER,
            User\AccountRole::DEFAULT_ROLE_MODERATOR,
            User\AccountRole::DEFAULT_ROLE_USER
        ];

    public $default_username = 'admin';
    public $default_userpass = 'admin@password';

    public function load(ObjectManager $manager)
    {
        // Check if admin role exists
        $userAccountRoleAdmin
            = $manager
            ->getRepository(User\AccountRole::class)
            ->findOneBy(['roleKey' => User\AccountRole::DEFAULT_ROLE_ADMIN]);
        if (!$userAccountRoleAdmin) {
            $userAccountRoleAdmin = new User\AccountRole();
            $userAccountRoleAdmin
                ->setKey(User\AccountRole::DEFAULT_ROLE_ADMIN)
                ->setTitle('Administrator')
                ->setStatus(1);
            $manager->persist($userAccountRoleAdmin);
            $manager->flush();
        }
        // Check if admin user exists
        $userAccountAdmin
            = $manager
            ->getRepository(User\Account::class)
            ->findOneBy(['username' => 'admin']);
        if (!$userAccountAdmin) {
            $userAccountAdmin = new User\Account();
            $userAccountAdmin
                ->setUsername($this->default_username)
                ->setPassword(md5($this->default_userpass))
                ->setStatus(1)
                ->setIsActivated(1)
                ->setAccountRole($userAccountRoleAdmin);
            $manager->persist($userAccountAdmin);
            $manager->flush();
        }
        unset($userAccountRoleAdmin, $userAccountAdmin);
        // Check if other default roles are exists
        // Developer, moderator and user
        foreach ($this->roles as $role) {
            if (!$manager
                ->getRepository(User\AccountRole::class)
                ->findOneBy(['roleKey' => $role])
            ) {
                $userAccountRole = new User\AccountRole();
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
