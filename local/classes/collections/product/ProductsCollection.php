<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:15
 */

namespace Local\Classes\Collections\Product;

use Local\Classes\Collections\Interfaces\CollectionInterface;

class ProductsCollection implements CollectionInterface
{
    private $products = [];

    public function addProduct(Product $product)
    {
        $this->products[$product->id] = $product;
    }

    public function getAll(): array
    {
        return $this->products;
    }

    public function notExists($id): bool
    {
        return !array_key_exists($id, $this->products);
    }

    public function getProduct($id): Product
    {
        return $this->products[$id];
    }

}