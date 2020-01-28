<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-05-08
 *     Time: 14:15
 */

namespace App\Traits;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

trait EntityManagerTrait
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * Returns entity repository collection
     *
     * @param string $entityClass
     * @return EntityRepository|ObjectRepository
     */
    public function getRepository(string $entityClass)
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }

    /**
     * Gets EntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager() : EntityManager
    {
        return $this->entityManager;
    }

    /**
     * Sets EntityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager) : self
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
