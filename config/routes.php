<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-10
 *     Time: 22:58
 */

use Mezzio\Application;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/db-test', App\Handler\DbTestHandler::class, 'db');

    // Account resources
    $app->get('/api/accounts[/{id}]', [
        BodyParamsMiddleware::class,
        App\Handler\HalResource\Account\AccountHandler::class,
    ], 'api.accounts.get');

    // Documentation
    $app->get(
        '/api/ping',
        App\Handler\PingHandler::class,
        'api.ping'
    );
    $app->get(
        '/api/doc/invalid-parameter',
        App\Doc\InvalidParameterHandler::class
    );
    $app->get(
        '/api/doc/method-not-allowed-error',
        App\Doc\MethodNotAllowedHandler::class
    );
    $app->get(
        '/api/doc/resource-not-found',
        App\Doc\ResourceNotFoundHandler::class
    );
    $app->get(
        '/api/doc/parameter-out-of-range',
        App\Doc\OutOfBoundsHandler::class
    );
    $app->get(
        '/api/doc/runtime-error',
        App\Doc\RuntimeErrorHandler::class
    );
};
