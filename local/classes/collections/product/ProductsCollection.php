<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:15
 */

namespace Local\Classes\Collections\Product;

class ProductsCollection
{
    private $products = [];

    public function addProduct(Product $product)
    {
        $this->products[$product->id] = $product;
    }

    public function getProducts()
    {
        return $this->products;
    }

}