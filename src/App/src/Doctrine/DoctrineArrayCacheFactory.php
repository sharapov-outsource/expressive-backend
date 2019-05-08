<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-10
 * Time: 22:30
 */

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;

class DoctrineArrayCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ArrayCache();
    }
}
