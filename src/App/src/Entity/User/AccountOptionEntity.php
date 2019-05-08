<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-04-28
 * Time: 22:15
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="AccountOption",
 * indexes={
 *   @ORM\Index(name="optionTypeKey", columns={"optionTypeKey"}),
 *   @ORM\Index(name="optionKey", columns={"optionKey"})
 * },
 *   uniqueConstraints={
 *   @ORM\UniqueConstraint(name="optionUnique", columns={"optionTypeKey", "optionKey", "account"})
 * })
 * @ORM\Entity(repositoryClass="AccountOptionRepository")
 */
class AccountOptionEntity
{
    const OPTION_TYPE_PERSONAL = 'personal';
    const OPTION_TYPE_ADDRESS = 'address';
    const OPTION_TYPE_CUSTOM = 'custom';
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
     *   @ORM\JoinColumn(name="account", referencedColumnName="id", onDelete="cascade")
     * })
     */
    protected $account;

    /**
     * UserAccountOption constructor.
     *
     * @param null $type
     * @param null $key
     * @param null $value
     */
    public function __construct($type = null, $key = null, $value = null)
    {
        $this->setIsRequired(0);
        $this->setReadOnly(0);
        if (!is_null($type) and !is_null($key)) {
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
     * @param $value
     *
     * @return $this
     */
    public function setIsRequired($value)
    {
        $this->isRequired = (bool)$value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return mixed
     */
    public function getOptionTypeKey()
    {
        return $this->optionTypeKey;
    }

    /**
     * @param $typeKey
     *
     * @return $this
     */
    public function setOptionTypeKey($typeKey)
    {
        switch ($typeKey) {
            case self::OPTION_TYPE_PERSONAL:
                $this->optionTypeKey = self::OPTION_TYPE_PERSONAL;
                break;
            case self::OPTION_TYPE_ADDRESS:
                $this->optionTypeKey = self::OPTION_TYPE_ADDRESS;
                break;
            case self::OPTION_TYPE_CUSTOM:
            default:
                $this->optionTypeKey = self::OPTION_TYPE_CUSTOM;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionKey()
    {
        return $this->optionKey;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOptionKey($value)
    {
        $this->optionKey = $value;
        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOptionValue($value)
    {
        $this->optionValue = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }

    /**
     * @param $key
     * @param $value
     * @param $isRequired
     * @param $readOnly
     *
     * @return $this
     */
    private function setOption($key, $value, $isRequired, $readOnly)
    {
        $this->setOptionKey($key);
        $this->setOptionValue($value);
        $this->setIsRequired($isRequired);
        $this->setReadOnly($readOnly);
        return $this;
    }

    /**
     * @param      $key
     * @param      $value
     * @param bool $isRequired
     * @param bool $readOnly
     *
     * @return $this
     */
    public function setOptionPersonal(
        $key,
        $value,
        $isRequired = false,
        $readOnly = false
    ) {
        $this->setOptionTypeKey(self::OPTION_TYPE_PERSONAL);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @param      $key
     * @param      $value
     * @param bool $isRequired
     * @param bool $readOnly
     *
     * @return $this
     */
    public function setOptionAddress(
        $key,
        $value,
        $isRequired = false,
        $readOnly = false
    ) {
        $this->setOptionTypeKey(self::OPTION_TYPE_ADDRESS);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @param      $key
     * @param      $value
     * @param bool $isRequired
     * @param bool $readOnly
     *
     * @return $this
     */
    public function setOptionCustom(
        $key,
        $value,
        $isRequired = false,
        $readOnly = false
    ) {
        $this->setOptionTypeKey(self::OPTION_TYPE_CUSTOM);
        $this->setOption($key, $value, $isRequired, $readOnly);
        return $this;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setReadOnly($status)
    {
        $this->readOnly = (bool)$status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @param AccountEntity $account
     *
     * @return $this
     */
    public function setAccount(AccountEntity $account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }
}
