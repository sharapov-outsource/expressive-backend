<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 22:11
 */

declare(strict_types=1);

namespace App\Handler;

use App\Traits\RouterTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;

class HomePageHandler implements RequestHandlerInterface
{
    use RouterTrait;

    public function __construct(
        Router\RouterInterface $router
    ) {
        $this
            ->setRouter($router);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            [
                'welcome' => 'Congratulations! You have installed the expressive-backend skeleton application.',
                'repoUrl' => 'https://github.com/sharapov-outsource/expressive-backend/',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]
        );
    }
}
