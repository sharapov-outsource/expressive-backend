<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-10
 * Time: 22:58
 */

declare(strict_types=1);

use App\Doctrine\DoctrineFactory;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

date_default_timezone_set("UTC"); // Set the default timezone

include 'vendor/autoload.php';

// Doctrine connection configuration
try {
    return ConsoleRunner::createHelperSet((new DoctrineFactory)(require 'config/container.php'));
} catch (ORMException $e) {
    throw new \RuntimeException($e->getMessage());
}
