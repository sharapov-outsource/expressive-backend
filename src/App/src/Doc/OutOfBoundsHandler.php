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

class OutOfBoundsHandler implements RequestHandlerInterface
{
    private const MESSAGE
    = <<<'EOT'
Parameter Out Of Range

Usually, this indicates that the "page" specified in the request is
invalid. Consider fetching the first page of the collection to
determine how many pages are available, and what the last page
in the collection is.

EOT;

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new TextResponse(self::MESSAGE);
    }
}
