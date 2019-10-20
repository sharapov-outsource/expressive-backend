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

use App\Entity\Account\AccountEntity;
use App\Exception\NoResourceFoundException;
use App\Exception\OutOfBoundsException;
use App\Traits\EntityManagerTrait;
use App\Traits\RestDispatchTrait;
use App\Traits\RouterTrait;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\Expressive\Router;

class AccountHandler implements RequestHandlerInterface
{
    use EntityManagerTrait;
    use RouterTrait;
    use RestDispatchTrait;

    public function __construct(
        EntityManager $entityManager,
        Router\RouterInterface $router,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    ) {
        $this
            ->setEntityManager($entityManager)
            ->setRouter($router);
        $this->resourceGenerator = $resourceGenerator;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Gets single user entity or collection
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id', false);

        return false === $id
            ? $this->getCollection($request)
            : $this->getSingle((int)$id, $request);
    }

    /**
     * Gets account collection
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws OutOfBoundsException
     */
    private function getCollection(
        ServerRequestInterface $request
    ): ResponseInterface {
        return $this->createResponse(
            $request,
            new AccountCollection(
                $this->getRepository(AccountEntity::class)
                    ->createQueryBuilder('c')
                    ->getQuery()
                    ->setMaxResults(25)
            )
        );
    }

    /**
     * Gets single account entity
     *
     * @param int                    $id
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    private function getSingle(
        int $id,
        ServerRequestInterface $request
    ): ResponseInterface {
        $account
            = $this->getRepository(AccountEntity::class)
            ->find($id);

        if (! $account instanceof AccountEntity) {
            throw NoResourceFoundException::create('Account not found');
        }

        return $this->createResponse($request, $account);
    }
}
