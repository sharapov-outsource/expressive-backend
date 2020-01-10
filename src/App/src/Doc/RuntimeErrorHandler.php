<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-02-23
 *     Time: 13:57
 */

namespace App\Doc;

use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RuntimeErrorHandler implements RequestHandlerInterface
{
    private const MESSAGE
    = <<<'EOT'
Runtime Error

A system error has prevented the request from completing. Try again,
and contact the API administrator if you continue to observe problems.

EOT;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new TextResponse(self::MESSAGE);
    }
}
