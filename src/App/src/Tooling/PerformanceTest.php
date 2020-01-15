<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 27.12.2019
 *     Time: 21:41
 */

namespace App\Tooling;

use App\Doctrine\DoctrineFactory;
use App\Doctrine\Fixtures\AccountsHugeCsv;
use App\Doctrine\Fixtures\AccountsHugeData;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\ORMException;
use Mezzio\Tooling\ConfigAndContainerTrait;
use Mezzio\Tooling\Module\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use function sprintf;

class PerformanceTest extends Command
{
    use ConfigAndContainerTrait;

    public const FIXTURES_PERFORMANCE_TEST_START = 'Starting performance test.';

    public const FIXTURES_PERFORMANCE_TEST_DONE = 'Performance test done.';

    public const FIXTURES_UNKNOWN_ACTION = 'Unknown action value';

    public const HELP = <<<'EOT'
Performance test.
EOT;

    /**
     * Configure command.
     */
    protected function configure(): void
    {
        $this->setDescription('Performance testing tool');
        $this->setHelp(self::HELP);
        $this->addArgument(
            'action',
            InputArgument::REQUIRED,
            'Accepts values: accounts, csv'
        );
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $loader = new Loader();
            $action = $input->getArgument('action');

            switch ($action) {
                case 'accounts':
                    $loader->addFixture(new AccountsHugeData());
                    break;
                case 'csv':
                    $loader->addFixture(new AccountsHugeCsv());
                    break;
                default:
                    throw new RuntimeException(self::FIXTURES_UNKNOWN_ACTION);
            }

            $output->writeln(sprintf(
                '<info>%s</info>',
                self::FIXTURES_PERFORMANCE_TEST_START
            ));


            $entityManager = (new DoctrineFactory())(require 'config/container.php');

            $executor = new ORMExecutor($entityManager);
            $executor->execute($loader->getFixtures(), true);

            $output->writeln(sprintf(
                '<info>%s</info>',
                self::FIXTURES_PERFORMANCE_TEST_DONE
            ));

            return 0;
        } catch (ORMException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
