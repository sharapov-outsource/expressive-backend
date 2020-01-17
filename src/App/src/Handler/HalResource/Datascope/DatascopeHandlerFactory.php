<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 18.01.2020
 * Time: 03:04
 */

namespace App\Handler\HalResource\Datascope;

use App\Handler\HalResource\Datascope\DatascopeHandler;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DatascopeHandlerFactory
{
    public function __invoke(
        ContainerInterface $container
    ) : RequestHandlerInterface {
        return new DatascopeHandler(
            $container->get('doctrine.entitymanager.orm_app'),
            $container->get(RouterInterface::class),
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
