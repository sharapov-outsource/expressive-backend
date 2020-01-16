<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-28
 *     Time: 22:15
 */

namespace App\Entity\Account;

use Doctrine\ORM\Mapping as ORM;

use function is_null;

/**
 * @ORM\Table(name="AccountOption",
 *     indexes={
 *     @ORM\Index(name="optionTypeKey", columns={"optionTypeKey"}),
 *     @ORM\Index(name="optionKey", columns={"optionKey"})
 *     },
 *     uniqueConstraints={
 *     @ORM\UniqueConstraint(name="optionUnique", columns={"optionTypeKey", "optionKey", "account"})
 *     })
 * @ORM\Entity(repositoryClass="AccountOptionRepository")
 */
class AccountOptionEntity
{
    public const OPTION_TYPE_PERSONAL = 'personal';
    public const OPTION_TYPE_ADDRESS = 'address';
    public const OPTION_TYPE_CUSTOM = 'custom';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="accountOptionType") */
    protected $optionTypeKey;

    /** @ORM\Column(type="string", length=32, nullable=false) */
    protected $optionKey;

    /** @ORM\Column(type="string", length=10000, nullable=false) */
    protected $optionValue;

    /** @ORM\Column(type="boolean", options={"default":false}) */
    protected $readOnly;

    /** @ORM\Column(type="boolean", options={"default":false}) */
    protected $isRequired;

    /**
     * @ORM\ManyToOne(targetEntity="AccountEntity")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="account", referencedColumnName="id", onDelete="cascade")
     * })
     */
    protected $account;

    /**
     * UserAccountOption constructor.
     *
     * @param null|string $type
     * @param null|string $key
     * @param null|mixed $value
     */
    public function __construct($type = null, $key = null, $value = null)
    {
        $this->setIsRequired(0);
        $this->setReadOnly(0);
        if (! is_null($type) && ! is_null($key)) {
            $this->setOptionTypeKey($type);
            $this->setOptionKey($key);
            $this->setOptionValue($value);
        }
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
    public function getIsRequired() : bool
    {
        return $this->isRequired;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsRequired(bool $value) : self
    {
        $this->isRequired = (bool) $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionTypeKey() : string
    {
        return $this->optionTypeKey;
    }

    /**
     * @param string $typeKey
     * @return $this
     */
    public function setOptionTypeKey(string $typeKey) : self
    {
        switch ($typeKey) {
            case self::OPTION_TYPE_PERSONAL:
                $this->optionTypeKey = self::OPTION_TYPE_PERSONAL;
                break;
            case self::OPTION_TYPE_ADDRESS:
                $this->optionTypeKey = self::OPTION_TYPE_ADDRESS;
                break;
            default:
                $this->optionTypeKey = self::OPTION_TYPE_CUSTOM;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionKey() : string
    {
        return $this->optionKey;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOptionKey(string $value) : self
    {
        $this->optionKey = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionValue() : string
    {
        return $this->optionValue;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOptionValue(string $value) : self
    {
        $this->optionValue = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool $isRequired
     * @param bool $readOnly
     * @return $this
     */
    public function setOptionPersonal(
        string $key,
        string $value,
        bool $isRequired = false,
        bool $readOnly = false
    ) : self {
        $this->setOptionTypeKey(self::OPTION_TYPE_PERSONAL);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param $isRequired
     * @param $readOnly
     * @return $this
     */
    private function setOption(string $key, string $value, bool $isRequired, bool $readOnly) : self
    {
        $this->setOptionKey($key);
        $this->setOptionValue($value);
        $this->setIsRequired($isRequired);
        $this->setReadOnly($readOnly);
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool $isRequired
     * @param bool $readOnly
     * @return $this
     */
    public function setOptionAddress(
        string $key,
        string $value,
        bool $isRequired = false,
        bool $readOnly = false
    ) : self {
        $this->setOptionTypeKey(self::OPTION_TYPE_ADDRESS);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool $isRequired
     * @param bool $readOnly
     * @return $this
     */
    public function setOptionCustom(
        string $key,
        string $value,
        bool $isRequired = false,
        bool $readOnly = false
    ) : self {
        $this->setOptionTypeKey(self::OPTION_TYPE_CUSTOM);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @return bool
     */
    public function getReadOnly() : bool
    {
        return $this->readOnly;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setReadOnly(bool $status) : self
    {
        $this->readOnly = (bool) $status;
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
}
