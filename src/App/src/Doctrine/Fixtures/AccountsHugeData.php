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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

use function microtime;
use function fwrite;
use function sprintf;
use function date;
use function ini_get;
use function strtolower;
use function uniqid;
use function number_format;
use function memory_get_usage;
use function memory_get_peak_usage;
use function md5;
use function mt_rand;
use function count;

use const DATE_W3C;
use const STDERR;
use const PHP_EOL;

class AccountsHugeData implements FixtureInterface
{
    /**
     * @var string
     */
    public static $defaultPassword = '123456';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 0;

        // You can increase or decrease the value depending on php memory limit
        $batchSize = 4000;

        $startTime = microtime(true);
        fwrite(STDERR, sprintf('Started at %s%s', date(DATE_W3C), PHP_EOL));
        fwrite(STDERR, sprintf(
            'PHP memory limit is %sMbytes and batch size is %s rows%s',
            ini_get('memory_limit'),
            $batchSize,
            PHP_EOL
        ));
        do {
            $accountRole = $manager
                ->getRepository(Account\AccountRoleEntity::class)
                ->findOneBy(['roleKey' => strtolower(Account\AccountRoleEntity::DEFAULT_ROLE_USER)]);

            /** @var Account\AccountRoleEntity $accountRole */
            $username = sprintf('%s@bixpressive.com', uniqid());

            $userAccount = new Account\AccountEntity();
            $userAccount
                ->setUsername($username)
                ->setPassword(md5(self::$defaultPassword))
                ->setStatus(true)
                ->setAccountRole($accountRole)
                ->setIsActivated(true)
                ->setAccountOption(new ArrayCollection([
                    (new Account\AccountOptionEntity())->setOptionPersonal('firstName', Faker\Name::firstName()),
                    (new Account\AccountOptionEntity())->setOptionPersonal('lastName', Faker\Name::lastName()),
                    (new Account\AccountOptionEntity())->setOptionPersonal(
                        'gender',
                        ['Male', 'Female'][mt_rand(0, count(['Male', 'Female']) - 1)]
                    ),
                ]));
            $manager->persist($userAccount);
            if ($i > 0 && $i % $batchSize === 0) {
                $manager->flush();
                $manager->clear();

                $current = memory_get_usage();
                $peak = memory_get_peak_usage();

                fwrite(
                    STDERR,
                    sprintf(
                        '%sPartially executed in %s seconds. Inserted %s records. Memory usage, current: %s, peak: %s.%s',
                        PHP_EOL,
                        number_format(microtime(true) - $startTime, 4),
                        $i,
                        $current,
                        $peak,
                        PHP_EOL
                    )
                );
            }
            if ($i % 50 === 0) {
                fwrite(STDERR, '.');
            }
            $i++;
        } while ($i < 60000);
        $manager->flush();
        fwrite(
            STDERR,
            sprintf(
                '%sTotally executed in %s seconds %s',
                PHP_EOL,
                number_format(microtime(true) - $startTime, 4),
                PHP_EOL
            )
        );
        fwrite(STDERR, sprintf('Ended at %s%s', date(DATE_W3C), PHP_EOL));
    }
}
