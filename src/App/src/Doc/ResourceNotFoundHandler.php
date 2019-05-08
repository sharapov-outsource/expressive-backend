<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-02-23
 * Time: 13:57
 */

declare(strict_types=1);

namespace App\Doc;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\TextResponse;

class ResourceNotFoundHandler implements RequestHandlerInterface
{
    private const MESSAGE
        = <<< 'EOT'
Resource Not Found

The resource you requested cannot be found. If you were using a specific
identifier, consider searching for the correct identifier in the corresponding
collection resource (usually obtained by stripping the identifier from the
URL).

EOT;

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(self::MESSAGE);
    }
}
