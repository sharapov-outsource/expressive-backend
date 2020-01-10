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

use Mezzio\Tooling\ConfigAndContainerTrait;
use Mezzio\Tooling\Module\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function file_exists;
use function getcwd;
use function realpath;
use function sprintf;
use function unlink;

class Cache extends Command
{
    use ConfigAndContainerTrait;

    const CONFIG_PATH_NOT_FOUND = 'No configuration cache path found.';

    const CONFIG_FILE_NOT_EXISTS = "Configured config cache file '%s' not found. This kind of cache is only in production mode, so perhaps your app is in development.";

    const CONFIG_NOT_REMOVED = "Error removing config cache file '%s'. Perhaps there is no write permissions.";

    const CONFIG_REMOVED = "Configured config cache file '%s' has been removed.";

    public const HELP = <<<'EOT'
Using this tool you can easily do the following:

- Clear configuration cache
EOT;

    /**
     * Configure command.
     */
    protected function configure() : void
    {
        $this->setDescription('Managing in-app caching functionality');
        $this->setHelp(self::HELP);
        $this->addArgument(
            'action',
            InputArgument::REQUIRED,
            'Accepts values: clear'
        );
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $config = $this->getConfig(realpath(getcwd()));

        if (! isset($config['config_cache_path'])) {
            throw new RuntimeException(self::CONFIG_PATH_NOT_FOUND);
        }

        if (! file_exists($config['config_cache_path'])) {
            throw new RuntimeException(
                sprintf(self::CONFIG_FILE_NOT_EXISTS, $config['config_cache_path'])
            );
        }

        if (false === unlink($config['config_cache_path'])) {
            throw new RuntimeException(
                sprintf(self::CONFIG_NOT_REMOVED, $config['config_cache_path'])
            );
        }

        $output->writeln(sprintf(
            '<info>%s</info>',
            sprintf(self::CONFIG_REMOVED, $config['config_cache_path'])
        ));

        return 0;
    }
}
