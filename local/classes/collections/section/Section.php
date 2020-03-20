<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:11
 */

namespace Local\Classes\Collections\Section;

use Local\Classes\Collections\Product\ProductsCollection;

class Section
{
    public $id;
    public $name;
    public $ufNewsLink;
    public $products;


    public function __construct(int $id, string $name, array $ufNewsLink, ProductsCollection $productsCollection)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ufNewsLink = $ufNewsLink;
        $this->products = $productsCollection;
    }

    public function countProducts()
    {
        return count($this->products->getProducts());
    }
}