<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\User\AccountRole;
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

    /** @var Router\RouterInterface */
    private $router;

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
        $roles = $this->getRepository(AccountRole::class);

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
