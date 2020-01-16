<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-28
 *     Time: 22:11
 */

namespace App\Handler\HalResource\Role;

use App\Entity\Account\AccountEntity;
use App\Entity\Account\AccountRoleEntity;
use App\Exception\NoResourceFoundException;
use App\Exception\OutOfBoundsException;
use App\Handler\HalResource\Role\RoleCollection;
use App\Traits\EntityManagerTrait;
use App\Traits\RestDispatchTrait;
use App\Traits\RouterTrait;
use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoleHandler implements RequestHandlerInterface
{
    use EntityManagerTrait;
    use RestDispatchTrait;
    use RouterTrait;

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
     * Gets single role entity or collection
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function get(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id', false);

        return $id === false
            ? $this->getCollection($request)
            : $this->getSingle((int) $id, $request);
    }

    /**
     * Gets roles collection
     *
     * @throws OutOfBoundsException
     */
    private function getCollection(
        ServerRequestInterface $request
    ) : ResponseInterface {
        return $this->createResponse(
            $request,
            new RoleCollection(
                $this->getRepository(AccountRoleEntity::class)
                     ->createQueryBuilder('c')
                     ->getQuery()
                     ->setMaxResults(25)
            )
        );
    }

    /**
     * Gets single role entity
     *
     * @param int $id
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws NoResourceFoundException
     */
    private function getSingle(
        int $id,
        ServerRequestInterface $request
    ) : ResponseInterface {
        $role
        = $this->getRepository(AccountRoleEntity::class)
               ->find($id);

        if (! $role instanceof AccountRoleEntity) {
            throw NoResourceFoundException::create('Role not found');
        }

        return $this->createResponse($request, $role);
    }
}
