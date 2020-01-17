<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 17.01.2020
 * Time: 01:24
 */

namespace App\Entity\Datascope;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Datascope")
 * @ORM\Entity(repositoryClass="DatascopeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class DatascopeEntity
{
    public const DATASCOPE_DEFAULT = 'default';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", length=32, nullable=false, unique=true) */
    protected $datascopeName;

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
    public function getDatascopeName() : string
    {
        return $this->datascopeName;
    }

    /**
     * @param string $datascopeName
     * @return $this
     */
    public function setDatascopeName(string $datascopeName) : self
    {
        $this->datascopeName = $datascopeName;
        return $this;
    }
}
