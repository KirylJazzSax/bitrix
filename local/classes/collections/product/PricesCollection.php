<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2020
 * Time: 17:49
 */

namespace Local\Classes\Collections\Product;


use ArrayIterator;
use IteratorAggregate;
use Local\Classes\Collections\Interfaces\CollectionInterface;
use Traversable;

class PricesCollection implements IteratorAggregate, CollectionInterface
{
    public $prices = [];

    public function add(Price $price): void
    {
        $this->prices[$price->idProduct] = $price;
    }

    public function getAll(): array
    {
        return $this->prices;
    }

    public function getMaxPrice()
    {
        return max(array_column($this->prices, 'price'));
    }

    public function getMinPrice()
    {
        return min(array_column($this->prices, 'price'));
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
        return new ArrayIterator($this);
    }
}