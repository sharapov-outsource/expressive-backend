<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 22:11
 */

declare(strict_types=1);

namespace App\Library;

use Psr\Container\ContainerInterface;

class ArrayDotAccessFactory
{
    public function __invoke(
        ContainerInterface $container
    ): ArrayDotAccess
    {
        return new ArrayDotAccess(
            $container->get('config')
        );
    }
}
