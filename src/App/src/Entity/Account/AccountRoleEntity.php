<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-28
 *     Time: 22:14
 */

namespace App\Entity\Account;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="AccountRole",
 *     indexes={
 *     @ORM\Index(name="roleKey", columns={"roleKey"})
 *     })
 * @ORM\Entity(repositoryClass="AccountRoleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AccountRoleEntity
{
    const DEFAULT_ROLE_ADMIN = 'administrator';
    const DEFAULT_ROLE_USER = 'user';
    const DEFAULT_ROLE_DEVELOPER = 'developer';
    const DEFAULT_ROLE_MODERATOR = 'moderator';
    const SORT_BY = 'roleTitle';
    const ORDER_BY = 'ASC';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", length=16, nullable=false, unique=true) */
    protected $roleKey;

    /** @ORM\Column(type="string", length=32, nullable=false, unique=true) */
    protected $roleTitle;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateCreated;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateUpdated;

    /** @ORM\Column(type="boolean", options={"default":true}) */
    protected $status;

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key) : self
    {
        $this->roleKey = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey() : string
    {
        return $this->roleKey;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTitle($value) : self
    {
        $this->roleTitle = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->roleTitle;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getStatus() : bool
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status) : self
    {
        $this->status = (bool) $status;
        return $this;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreated
             = $this->dateUpdated = new DateTime('now');
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->dateUpdated = new DateTime('now');
    }

    private function __clone()
    {
        // Private clone method to prevent cloning of the instance of the *Singleton* instance.
    }
}
