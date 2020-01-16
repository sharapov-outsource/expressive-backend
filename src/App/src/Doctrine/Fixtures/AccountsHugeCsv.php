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
use function sys_get_temp_dir;
use function fopen;
use function fclose;
use function fputcsv;
use function json_encode;
use function mt_rand;
use function count;
use function feof;
use function fgetcsv;
use function json_decode;

use const DATE_W3C;
use const STDERR;
use const PHP_EOL;

class AccountsHugeCsv extends AccountsHugeData implements FixtureInterface
{
    /**
     * @var array
     */
    public $csvFieldNames = [
        'Username',
        'Password',
        'Status',
        'IsActivated',
        'AccountRole',
        'AccountOptions',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 0;
        $testRows = 20;

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
        fwrite(STDERR, sprintf('Generating test CSV file%s', PHP_EOL));
        $tmpFile = $this->generateTestCsv($testRows);
        fwrite(STDERR, sprintf('%sCSV file with %s rows is successfully created%s', PHP_EOL, $testRows, PHP_EOL));

        $csv = fopen($tmpFile, 'r');

        do {
            // Get line
            $line = fgetcsv($csv);

            // Skip the line if it broken or contains less columns than needed
            if (! $line || count($line) < count($this->csvFieldNames)) {
                $i++;
                continue;
            }

            // TODO: On first row we have to validate columns on provided CSV, but for now we just skip it
            if ($i === 0) {
                $i++;
                continue;
            }

            /** @var Account\AccountRoleEntity $accountRole */
            $userAccount = new Account\AccountEntity();

            // Fill the data fields
            foreach ($this->csvFieldNames as $f => $fieldName) {
                switch ($fieldName) {
                    case 'AccountRole':
                        $accountRole = $manager
                            ->getRepository(Account\AccountRoleEntity::class)
                            ->findOneBy(['roleKey' => strtolower($line[$f])]);
                        $userAccount
                            ->setAccountRole($accountRole);
                        break;
                    case 'AccountOptions':
                        $accountOptions = json_decode($line[$f]);

                        $arrayCollection = new ArrayCollection();
                        foreach ($accountOptions as $accountOptionType => $accountOptionValues) {
                            foreach ($accountOptionValues as $accountOptionKey => $accountOptionValue) {
                                $arrayCollection
                                    ->add(
                                        new Account\AccountOptionEntity(
                                            $accountOptionType,
                                            $accountOptionKey,
                                            $accountOptionValue
                                        )
                                    );
                            }
                        }
                        $userAccount
                            ->setAccountOption($arrayCollection);
                        break;
                    case 'Username':
                    case 'Password':
                    case 'Status':
                    case 'IsActivated':
                        $userAccount->{'set' . $fieldName}($line[$f]);
                        break;
                }
            }

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
        } while (! feof($csv));
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

    /**
     * Generate test csv
     *
     * @param int $testRows The number of test rows
     * @return string
     */
    private function generateTestCsv(int $testRows) : string
    {
        $tmp = sys_get_temp_dir() . '/' . uniqid('test_csv_') . '.csv';
        $fp = fopen($tmp, 'w');

        // Setup the first row
        fputcsv($fp, $this->csvFieldNames);
        for ($i = 0; $i < $testRows; $i++) {
            fputcsv($fp, $this->generateTestCsvDataRow());
            if ($i % 150 === 0) {
                fwrite(STDERR, '.');
            }
        }

        fclose($fp);

        return $tmp;
    }

    /**
     * Generate a csv row
     */
    private function generateTestCsvDataRow() : array
    {
        $outRow = [];
        foreach ($this->csvFieldNames as $fieldName) {
            switch ($fieldName) {
                case 'Username':
                    $outRow[] = sprintf('%s@bixpressive.com', uniqid());
                    break;
                case 'Password':
                    $outRow[] = md5(self::$defaultPassword);
                    break;
                case 'Status':
                case 'IsActivated':
                    $outRow[] = 1;
                    break;
                case 'AccountRole':
                    $outRow[] = Account\AccountRoleEntity::DEFAULT_ROLE_USER;
                    break;
                case 'AccountOptions':
                    $outRow[] = json_encode([
                        Account\AccountOptionEntity::OPTION_TYPE_PERSONAL => [
                            'firstName' => Faker\Name::firstName(),
                            'lastName' => Faker\Name::lastName(),
                            'gender' => ['Male', 'Female'][mt_rand(0, count(['Male', 'Female']) - 1)],
                        ],
                        Account\AccountOptionEntity::OPTION_TYPE_ADDRESS => [
                            'addressLine1' => Faker\Address::streetAddress(),
                            'addressLine2' => Faker\Address::secondaryAddress(),
                            'Country' => Faker\Address::country(),
                            'City' => Faker\Address::city(),
                            'PostalCode' => Faker\Address::zipCode(),
                        ],
                        Account\AccountOptionEntity::OPTION_TYPE_CUSTOM => [
                            'Phone' => Faker\PhoneNumber::phoneNumber(),
                        ],
                    ]);
                    break;
            }
        }

        return $outRow;
    }
}
