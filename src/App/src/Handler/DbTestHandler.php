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

use App\Entity\User\AccountRoleEntity;
use App\Traits\EntityManagerTrait;
use App\Traits\RouterTrait;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;

class DbTestHandler implements RequestHandlerInterface
{
    use EntityManagerTrait;
    use RouterTrait;

    public function __construct(
        EntityManager $entityManager,
        Router\RouterInterface $router
    ) {
        $this
            ->setEntityManager($entityManager)
            ->setRouter($router);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $roles = $this->getRepository(AccountRoleEntity::class);

        $rolesCollection = [];
        foreach ($roles->findAll() as $role) {
            $rolesCollection[] = $role->getTitle();
        }

        return new JsonResponse(
            [
                'roles' => $rolesCollection,
            ]
        );
    }
}
