<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 22:11
 */

namespace App\Entity\Account;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Exception;

/**
 * @ORM\Table(name="Account",
 * indexes={
 *   @ORM\Index(name="username", columns={"username"}),
 *   @ORM\Index(name="status", columns={"status"})
 * })
 * @ORM\Entity(repositoryClass="AccountRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AccountEntity
{
    const SORT_BY = 'id';
    const ORDER_BY = 'ASC';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @ORM\Column(type="string", length=32, nullable=false, unique=true) */
    protected $username;
    /** @ORM\Column(type="string", length=32, nullable=false) */
    protected $password;
    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateCreated;
    /** @ORM\Column(type="datetime", nullable=false) */
    protected $dateUpdated;
    /** @ORM\Column(type="datetime", nullable=true) */
    protected $timeStampLastActive;
    /** @ORM\Column(type="boolean", options={"default":true}) */
    protected $status;
    /** @ORM\Column(type="boolean", options={"default":false}) */
    protected $isActivated;
    /** @ORM\Column(type="string", length=128, nullable=true) */
    protected $activateToken;
    /**
     * @ORM\ManyToOne(targetEntity="AccountRoleEntity", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="accountRole", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $accountRole;
    /**
     * @ORM\OneToMany(targetEntity="AccountOptionEntity",mappedBy="account", cascade={"persist"})
     * @ORM\OrderBy({"optionKey" = "ASC"})
     */
    protected $accountOption;
    /**
     * User account default options
     *
     * @var array
     */
    protected $accountDefaultOptions
        = [
            AccountOptionEntity::OPTION_TYPE_PERSONAL => [
                'firstName',
                'lastName',
                'birthDate',
                'avatar',
            ],
            AccountOptionEntity::OPTION_TYPE_ADDRESS  => [
                'country',
                'state',
                'city',
                'zipcode',
            ]
        ];

    /**
     * UserAccount constructor.
     */
    public function __construct()
    {
        $this->setIsActivated(0);
        $this->setStatus(1);
    }

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
    public function isUpdate()
    {
        return (bool)$this->id == 'NULL';
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param null $format
     *
     * @return mixed
     */
    public function getDateCreated($format = null)
    {
        if (! is_null($format)) {
            return $this->dateCreated->format($format);
        }
        return $this->dateCreated;
    }

    /**
     * @param null $format
     *
     * @return mixed
     */
    public function getDateUpdated($format = null)
    {
        if (! is_null($format)) {
            return $this->dateUpdated->format($format);
        }
        return $this->dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = (bool)$status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setIsActivated($status)
    {
        $this->isActivated = (bool)$status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivateToken()
    {
        return $this->activateToken;
    }

    /**
     * @param $activateToken
     *
     * @return $this
     */
    public function setActivateToken($activateToken)
    {
        $this->activateToken = $activateToken;
        return $this;
    }

    /**
     * @return AccountRoleEntity|null
     */
    public function getAccountRole()
    {
        return $this->accountRole;
    }

    /**
     * @param AccountRoleEntity $accountRole
     *
     * @return $this
     */
    public function setAccountRole(AccountRoleEntity $accountRole)
    {
        $this->accountRole = $accountRole;
        return $this;
    }

    /**
     * @param null $format
     *
     * @return mixed
     */
    public function getTimeStampLastActive($format = null)
    {
        if (! is_null($format)) {
            return $this->timeStampLastActive->format($format);
        }
        return $this->timeStampLastActive;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function setTimeStampLastActive()
    {
        $this->timeStampLastActive = new DateTime('now');
        return $this;
    }

    /**
     * @param      $optionTypeKey
     * @param bool $returnAssoc
     *
     * @return array|bool|Collection|null
     */
    public function getAccountTypeOptionCollection(
        $optionTypeKey,
        $returnAssoc = false
    ) {
        if ($this->accountOption instanceof PersistentCollection) {
            $collection = $this->accountOption->filter(
                function ($option) use ($optionTypeKey) {
                    if ($option instanceof AccountOptionEntity) {
                        return ($optionTypeKey == $option->getOptionTypeKey());
                    } else {
                        return null;
                    }
                }
            );
            if ($collection) {
                if ($returnAssoc) {
                    $returnAssoc = [];
                    foreach ($collection as $option) {
                        /** @var AccountOptionEntity $option */
                        $returnAssoc[$option->getOptionKey()]
                            = $option->getOptionValue();
                    }
                    return $returnAssoc;
                } else {
                    return $collection;
                }
            }
        }
        return null;
    }

    /**
     * @param null $optionKey
     * @param bool $returnObject
     *
     * @return array|PersistentCollection|mixed
     */
    public function getAccountOption($optionKey = null, $returnObject = false)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            if (is_null($optionKey)) {
                return $this->accountOption;
            }
            $option = $this->accountOption->filter(
                function ($option) use ($optionKey) {
                    if ($option instanceof AccountOptionEntity) {
                        return ($optionKey == $option->getOptionKey());
                    } else {
                        return null;
                    }
                }
            )->current();
            if ($option) {
                return ($returnObject) ? $option : $option->getOptionValue();
            }
        }
        return [];
    }

    /**
     * @param ArrayCollection $arrayCollection
     *
     * @return AccountEntity
     */
    public function setAccountOption(ArrayCollection $arrayCollection)
    {
        return $this->addAccountOption($arrayCollection);
    }

    /**
     * @param ArrayCollection $arrayCollection
     *
     * @return $this
     */
    public function addAccountOption(ArrayCollection $arrayCollection)
    {
        foreach ($arrayCollection as $item) {
            $item->setAccount($this);
        }
        $this->accountOption = $arrayCollection;
        return $this;
    }

    /**
     * @param $optionKey
     * @param $optionValue
     *
     * @return bool|null
     */
    public function updateAccountOption($optionKey, $optionValue)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            $option = $this->accountOption->filter(
                function ($option) use ($optionKey) {
                    if ($option instanceof AccountOptionEntity) {
                        return ($optionKey == $option->getOptionKey());
                    } else {
                        return null;
                    }
                }
            )->current();
            if ($option) {
                $option->setOptionValue($optionValue);
                return true;
            }
        }
        return null;
    }

    /**
     * @param $optionKey
     *
     * @return mixed|null
     */
    public function removeAccountOption($optionKey)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            return $this->accountOption->filter(
                function ($option) use ($optionKey) {
                    if ($option instanceof AccountOptionEntity) {
                        unset($option);
                        return true;
                    } else {
                        return null;
                    }
                }
            )->current();
        }
        return null;
    }

    /**
     * @return Collection|null
     */
    public function getAccountOptionListPersonal()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_PERSONAL);
    }

    /**
     * @param $typeKey
     *
     * @return Collection|null
     */
    private function filterAccountOptionType($typeKey)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            $option = $this->accountOption->filter(
                function ($option) use ($typeKey) {
                    /** @var AccountOptionEntity $option */
                    return ($typeKey == $option->getOptionTypeKey());
                }
            );
            if ($option) {
                return $option;
            }
        }
        return null;
    }

    /**
     * @return Collection|null
     */
    public function getAccountOptionListAddress()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_ADDRESS);
    }

    /**
     * @return Collection|null
     */
    public function getAccountOptionListCustom()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_CUSTOM);
    }

    /**
     * @return array
     */
    public function getAccountDefaultOptions()
    {
        return $this->accountDefaultOptions;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreated = $this->dateUpdated = new DateTime("now");
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->dateUpdated = new DateTime("now");
    }
}
