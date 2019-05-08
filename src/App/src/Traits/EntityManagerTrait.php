<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-05-08
 * Time: 14:15
 */

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\EntityManager;

trait EntityManagerTrait
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * Sets EntityManager
     *
     * @param EntityManager $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager): self
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * Gets EntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Returns entity repository collection
     *
     * @param string $entityClass
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    public function getRepository(string $entityClass)
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }
}
