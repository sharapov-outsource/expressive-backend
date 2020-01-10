<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-28
 *     Time: 22:11
 */

namespace App\Handler;

use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DbTestHandlerFactory
{
    public function __invoke(
        ContainerInterface $container
    ) : RequestHandlerInterface {
        return new DbTestHandler(
            $container->get('doctrine.entitymanager.orm_app'),
            $container->get(RouterInterface::class)
        );
    }
}
