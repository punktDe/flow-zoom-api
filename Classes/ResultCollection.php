<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;

class ResultCollection implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $pagesTotal;

    /**
     * @var int
     */
    protected $elementsTotal;

    /**
     * @var mixed[]
     */
    protected $elements = [];

    /**
     * Adds an element at the end of the collection.
     *
     * @param mixed $element The element to add.
     * @return void
     */
    public function add($element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Clears the collection, removing all elements.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->elements = [];
    }

    /**
     * Checks whether an element is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param mixed $element The element to search for.
     *
     * @return bool TRUE if the collection contains the element, FALSE otherwise.
     */
    public function contains($element): bool
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * Checks whether the collection is empty (contains no elements).
     *
     * @return bool TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    /**
     * Removes the element at the specified index from the collection.
     *
     * @param string|int $key The kex/index of the element to remove.
     *
     * @return mixed The removed element or NULL, if the collection did not contain the element.
     */
    public function remove($key)
    {
        if (!isset($this->elements[$key])) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    /**
     * Removes the specified element from the collection, if it is found.
     *
     * @param mixed $element The element to remove.
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeElement($element): bool
    {
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);
        return true;
    }

    /**
     * Checks whether the collection contains an element with the specified key/index.
     *
     * @param string|int $key The key/index to check for.
     *
     * @return bool TRUE if the collection contains an element with the specified key/index,
     *              FALSE otherwise.
     */
    public function containsKey($key): bool
    {
        return isset($this->elements[$key]);
    }

    /**
     * Gets the element at the specified key/index.
     *
     * @param string|int $key The key/index of the element to retrieve.
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->elements[$key] ?? null;
    }

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array The keys/indices of the collection, in the order of the corresponding
     *               elements in the collection.
     */
    public function getKeys(): array
    {
        return array_keys($this->elements);
    }

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all elements in the collection, in the order they
     *               appear in the collection.
     */
    public function getValues(): array
    {
        return array_values($this->elements);
    }

    /**
     * Sets an element in the collection at the specified key/index.
     *
     * @param string|int $key The key/index of the element to set.
     * @param mixed $value The element to set.
     *
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->elements[$key] = $value;
    }

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * Sets the internal iterator to the first element in the collection and returns this element.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * Sets the internal iterator to the last element in the collection and returns this element.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * Gets the key/index of the element at the current iterator position.
     *
     * @return int|string
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * Gets the element of the collection at the current iterator position.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * Moves the internal iterator position to the next element and returns this element.
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            $this->add($value);
            return;
        }

        $this->set($offset, $value);
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPagesTotal(): int
    {
        return $this->pagesTotal;
    }

    /**
     * @return int
     */
    public function getElementsTotal(): int
    {
        return $this->elementsTotal;
    }

    /**
     * @param int $currentPage
     * @return ResultCollection
     */
    public function setCurrentPage(int $currentPage): ResultCollection
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @param int $pagesTotal
     * @return ResultCollection
     */
    public function setPagesTotal(int $pagesTotal): ResultCollection
    {
        $this->pagesTotal = $pagesTotal;
        return $this;
    }

    /**
     * @param int $elementsTotal
     * @return ResultCollection
     */
    public function setElementsTotal(int $elementsTotal): ResultCollection
    {
        $this->elementsTotal = $elementsTotal;
        return $this;
    }
}
