<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-28
 *     Time: 22:11
 */

namespace App\Entity\Account;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Exception;

use function is_null;

/**
 * @ORM\Table(name="Account",
 *     indexes={
 *     @ORM\Index(name="username", columns={"username"}),
 *     @ORM\Index(name="status", columns={"status"})
 *     })
 * @ORM\Entity(repositoryClass="AccountRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AccountEntity
{
    public const SORT_BY = 'id';
    public const ORDER_BY = 'ASC';

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
     *     @ORM\JoinColumn(name="accountRole", referencedColumnName="id", onDelete="SET NULL")
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
            'gender',
            'avatar',
        ],
        AccountOptionEntity::OPTION_TYPE_ADDRESS => [
            'country',
            'state',
            'city',
            'zipCode',
        ],
    ];

    /**
     * UserAccount constructor.
     */
    public function __construct()
    {
        $this->setIsActivated(false);
        $this->setStatus(true);
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
    public function isUpdate() : bool
    {
        return (bool) $this->id === 'NULL';
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username) : self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password) : self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param null|string $format
     * @return mixed
     */
    public function getDateCreated($format = null)
    {
        if ($format !== null) {
            return $this->dateCreated->format($format);
        }
        return $this->dateCreated;
    }

    /**
     * @param null|string $format
     * @return mixed
     */
    public function getDateUpdated($format = null)
    {
        if ($format !== null) {
            return $this->dateUpdated->format($format);
        }
        return $this->dateUpdated;
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
     * @return bool
     */
    public function getIsActivated() : bool
    {
        return $this->isActivated;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setIsActivated(bool $status) : self
    {
        $this->isActivated = (bool) $status;
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
     * @param string $activateToken
     * @return $this
     */
    public function setActivateToken(string $activateToken) : self
    {
        $this->activateToken = $activateToken;
        return $this;
    }

    /**
     * @return null|AccountRoleEntity
     */
    public function getAccountRole()
    {
        return $this->accountRole;
    }

    /**
     * @param AccountRoleEntity $accountRole
     * @return $this
     */
    public function setAccountRole(AccountRoleEntity $accountRole) : self
    {
        $this->accountRole = $accountRole;
        return $this;
    }

    /**
     * @param null|string $format
     * @return mixed
     */
    public function getTimeStampLastActive($format = null)
    {
        if ($format !== null) {
            return $this->timeStampLastActive->format($format);
        }
        return $this->timeStampLastActive;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function setTimeStampLastActive() : self
    {
        $this->timeStampLastActive = new DateTime('now');
        return $this;
    }

    /**
     * @param string $optionTypeKey
     * @param bool $returnAssoc
     * @return null|array|bool|Collection
     */
    public function getAccountTypeOptionCollection(
        string $optionTypeKey,
        bool $returnAssoc = false
    ) {
        if ($this->accountOption instanceof PersistentCollection) {
            $collection = $this->accountOption->filter(
                static function ($option) use ($optionTypeKey) {
                    if ($option instanceof AccountOptionEntity) {
                        return $optionTypeKey === $option->getOptionTypeKey();
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
     * @param null|string $optionKey
     * @param bool $returnObject
     * @return array|PersistentCollection|mixed
     */
    public function getAccountOption($optionKey = null, $returnObject = false)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            if ($optionKey === null) {
                return $this->accountOption;
            }
            $option = $this->accountOption->filter(
                                              static function ($option) use ($optionKey) {
                                                  if ($option instanceof AccountOptionEntity) {
                                                      return $optionKey === $option->getOptionKey();
                                                  } else {
                                                      return null;
                                                  }
                                              }
                                          )
                                          ->current();
            if ($option) {
                return $returnObject ? $option : $option->getOptionValue();
            }
        }
        return [];
    }

    /**
     * @param ArrayCollection $arrayCollection
     * @return $this
     */
    public function setAccountOption(ArrayCollection $arrayCollection) : self
    {
        return $this->addAccountOption($arrayCollection);
    }

    /**
     * @param ArrayCollection $arrayCollection
     * @return $this
     */
    public function addAccountOption(ArrayCollection $arrayCollection) : self
    {
        foreach ($arrayCollection as $item) {
            $item->setAccount($this);
        }
        $this->accountOption = $arrayCollection;
        return $this;
    }

    /**
     * @param string $optionKey
     * @param string $optionValue
     * @return null|bool
     */
    public function updateAccountOption(string $optionKey, string $optionValue)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            $option = $this->accountOption->filter(
                                              static function ($option) use ($optionKey) {
                                                  if ($option instanceof AccountOptionEntity) {
                                                      return $optionKey === $option->getOptionKey();
                                                  } else {
                                                      return null;
                                                  }
                                              }
                                          )
                                          ->current();
            if ($option) {
                $option->setOptionValue($optionValue);
                return true;
            }
        }
        return null;
    }

    /**
     * @param string $optionKey
     * @return null|mixed
     */
    public function removeAccountOption(string $optionKey)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            return $this->accountOption->filter(
                                           static function ($option) use ($optionKey) {
                                               if ($option instanceof AccountOptionEntity) {
                                                   unset($option);
                                                   return true;
                                               } else {
                                                   return null;
                                               }
                                           }
                                       )
                                       ->current();
        }
        return null;
    }

    /**
     * @return null|Collection
     */
    public function getAccountOptionListPersonal()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_PERSONAL);
    }

    /**
     * @param string $typeKey
     * @return null|Collection
     */
    private function filterAccountOptionType(string $typeKey)
    {
        if ($this->accountOption instanceof PersistentCollection) {
            $option = $this->accountOption->filter(
                static function ($option) use ($typeKey) {
                    /** @var AccountOptionEntity $option */
                    return $typeKey === $option->getOptionTypeKey();
                }
            );
            if ($option) {
                return $option;
            }
        }
        return null;
    }

    /**
     * @return null|Collection
     */
    public function getAccountOptionListAddress()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_ADDRESS);
    }

    /**
     * @return null|Collection
     */
    public function getAccountOptionListCustom()
    {
        return $this->filterAccountOptionType(AccountOptionEntity::OPTION_TYPE_CUSTOM);
    }

    /**
     * @return array
     */
    public function getAccountDefaultOptions() : array
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
        $this->dateCreated = $this->dateUpdated = new DateTime('now');
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
}
