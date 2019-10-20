<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 19.10.2019
 * Time: 22:11
 */

declare(strict_types=1);

namespace App\Doctrine\Hydrator\Strategy;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use InvalidArgumentException;
use ReflectionException;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.7.0
 * @author  Michael Gallego <mic.gallego@gmail.com>
 */
abstract class AbstractCollectionStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    protected $collectionName;

    /**
     * @var ClassMetadata
     */
    protected $metadata;

    /**
     * @var object
     */
    protected $object;

    /**
     * Set the class metadata
     *
     * @param ClassMetadata $classMetadata
     *
     * @return AbstractCollectionStrategy
     */
    public function setClassMetadata(ClassMetadata $classMetadata)
    {
        $this->metadata = $classMetadata;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function extract($value, ?object $object = null)
    {
        return $value;
    }

    /**
     * Return the collection by value (using the public API)
     *
     * @return Collection
     * @throws InvalidArgumentException
     *
     */
    protected function getCollectionFromObjectByValue()
    {
        $object = $this->getObject();
        $getter = 'get' . Inflector::classify($this->getCollectionName());

        if (! method_exists($object, $getter)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The getter %s to access collection %s in object %s does not exist',
                    $getter,
                    $this->getCollectionName(),
                    get_class($object)
                )
            );
        }

        return $object->$getter();
    }

    /**
     * Get the object
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the object
     *
     * @param object $object
     *
     * @return AbstractCollectionStrategy
     * @throws InvalidArgumentException
     *
     */
    public function setObject($object)
    {
        if (! is_object($object)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The parameter given to setObject method of %s class is not an object',
                    get_called_class()
                )
            );
        }

        $this->object = $object;
        return $this;
    }

    /**
     * Get the name of the collection
     *
     * @return string
     */
    public function getCollectionName()
    {
        return $this->collectionName;
    }

    /**
     * Set the name of the collection
     *
     * @param string $collectionName
     *
     * @return AbstractCollectionStrategy
     */
    public function setCollectionName($collectionName)
    {
        $this->collectionName = (string)$collectionName;
        return $this;
    }

    /**
     * Return the collection by reference (not using the public API)
     *
     * @return Collection
     * @throws ReflectionException
     */
    protected function getCollectionFromObjectByReference()
    {
        $object = $this->getObject();
        $refl = $this->getClassMetadata()->getReflectionClass();
        $reflProperty = $refl->getProperty($this->getCollectionName());

        $reflProperty->setAccessible(true);

        return $reflProperty->getValue($object);
    }

    /**
     * Get the class metadata
     *
     * @return ClassMetadata
     */
    public function getClassMetadata()
    {
        return $this->metadata;
    }

    /**
     * This method is used internally by array_udiff to check if two objects are equal, according to their
     * SPL hash. This is needed because the native array_diff only compare strings
     *
     * @param object $a
     * @param object $b
     *
     * @return int
     */
    protected function compareObjects($a, $b)
    {
        return strcmp(spl_object_hash($a), spl_object_hash($b));
    }
}
