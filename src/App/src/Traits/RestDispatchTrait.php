<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-02-23
 *     Time: 13:57
 */

namespace App\Traits;

use App\Exception;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Hal\ResourceGenerator\Exception\OutOfBoundsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function method_exists;
use function sprintf;
use function strtolower;
use function strtoupper;

trait RestDispatchTrait
{
    /**
     * @var ResourceGenerator
     */
    private $resourceGenerator;

    /**
     * @var HalResponseFactory
     */
    private $responseFactory;

    /**
     * Proxies to method named after lowercase HTTP method, if present.
     * Otherwise, returns an empty 501 response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $method = strtolower($request->getMethod());
        if (method_exists($this, $method)) {
            return $this->$method($request);
        }
        throw Exception\MethodNotAllowedException::create(sprintf(
            'Method %s is not implemented for the requested resource',
            strtoupper($method)
        ));
    }

    /**
     * Create a HAL response from the given $instance, based on the incoming $request.
     *
     * @param $instance
     * @throws Exception\OutOfBoundsException if an `OutOfBoundsException` is
     *     thrown by the response factory and/or resource generator.
     */
    private function createResponse(
        ServerRequestInterface $request,
        $instance
    ) : ResponseInterface {
        try {
            return $this->getResponseFactory()->createResponse(
                $request,
                $this->getResourceGenerator()
                     ->fromObject($instance, $request)
            );
        } catch (OutOfBoundsException $e) {
            throw Exception\OutOfBoundsException::create($e->getMessage());
        }
    }

    /**
     * Gets response factory
     *
     * @return HalResponseFactory
     */
    public function getResponseFactory()
    {
        return $this->responseFactory;
    }

    /**
     * Sets response factory
     *
     * @return $this
     */
    public function setResponseFactory(HalResponseFactory $halResponseFactory) : self
    {
        $this->responseFactory = $halResponseFactory;
        return $this;
    }

    /**
     * Gets resource generator
     *
     * @return ResourceGenerator
     */
    public function getResourceGenerator()
    {
        return $this->resourceGenerator;
    }

    /**
     * Sets resource generator
     *
     * @return $this
     */
    public function setResourceGenerator(ResourceGenerator $resourceGenerator) : self
    {
        $this->resourceGenerator = $resourceGenerator;
        return $this;
    }
}
