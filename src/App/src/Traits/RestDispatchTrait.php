<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-02-23
 * Time: 13:57
 */

declare(strict_types=1);

namespace App\Traits;

use App\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\Expressive\Hal\ResourceGenerator\Exception\OutOfBoundsException;

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
     * {@inheritDoc}
     *
     * @throws Exception\MethodNotAllowedException if no matching method is found.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
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
     * @param ServerRequestInterface $request
     * @param                        $instance
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Exception\OutOfBoundsException if an `OutOfBoundsException` is
     *     thrown by the response factory and/or resource generator.
     */
    private function createResponse(
        ServerRequestInterface $request,
        $instance
    ): ResponseInterface {
        try {
            return
                $this->getResponseFactory()->createResponse(
                    $request,
                    $this->getResourceGenerator()
                        ->fromObject($instance, $request)
                );
        } catch (OutOfBoundsException $e) {
            throw Exception\OutOfBoundsException::create($e->getMessage());
        }
    }

    /**
     * Sets resource generator
     *
     * @param ResourceGenerator $resourceGenerator
     *
     * @return $this
     */
    public function setResourceGenerator(ResourceGenerator $resourceGenerator
    ): self {
        $this->resourceGenerator = $resourceGenerator;
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
     * Sets response factory
     *
     * @param HalResponseFactory $halResponseFactory
     *
     * @return $this
     */
    public function setResponseFactory(HalResponseFactory $halResponseFactory
    ): self {
        $this->responseFactory = $halResponseFactory;
        return $this;
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
}
