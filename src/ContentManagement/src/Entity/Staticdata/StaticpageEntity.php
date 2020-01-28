<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 18.01.2020
 * Time: 02:40
 */

namespace ContentManagement\Entity\Staticdata;

use App\Entity\Account\AccountEntity;
use App\Entity\Datascope\DatascopeEntity;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="Staticpage")
 * @ORM\Entity(repositoryClass="StaticpageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class StaticpageEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", length=1000, nullable=false) */
    protected $title;

    /** @ORM\Column(type="string", length=100000, nullable=true) */
    protected $content;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateCreated;

    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateUpdated;

    /** @ORM\Column(type="boolean", options={"default":true}) */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account\AccountEntity")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="account", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $account;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Datascope\DatascopeEntity")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="datascope", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $datascope;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isUpdate() : bool
    {
        return (bool) $this->id === 'NULL';
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content) : self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus() : bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status) : self
    {
        $this->status = (bool) $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param AccountEntity $account
     * @return $this
     */
    public function setAccount(AccountEntity $account) : self
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatascope()
    {
        return $this->datascope;
    }

    /**
     * @param DatascopeEntity $datascope
     * @return $this
     */
    public function setDatascope(DatascopeEntity $datascope) : self
    {
        $this->datascope = $datascope;
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
