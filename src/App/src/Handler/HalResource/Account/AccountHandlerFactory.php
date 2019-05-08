<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 22:11
 */

declare(strict_types=1);

namespace App\Handler\HalResource\Account;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\Expressive\Router\RouterInterface;

class AccountHandlerFactory
{
    public function __invoke(
        ContainerInterface $container
    ): RequestHandlerInterface {
        return new AccountHandler(
            $container->get('doctrine.entitymanager.orm_app'),
            $container->get(RouterInterface::class),
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
