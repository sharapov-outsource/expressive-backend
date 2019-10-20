<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zend\Expressive\MiddlewareFactory;

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
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/db-test', App\Handler\DbTestHandler::class, 'db');

    // Account resources
    $app->get('/api/accounts[/{id}]', [
        BodyParamsMiddleware::class,
        App\Handler\HalResource\Account\AccountHandler::class
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
