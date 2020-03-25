<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.03.2020
 * Time: 19:00
 */

namespace Local\Classes\Collections\Manufacturing;


use Local\Classes\Collections\Product\ProductsCollection;

class Manufacturing
{
    public $id;
    public $name;
    public $products;

    public function __construct(int $id, string $name, ProductsCollection $products)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = $products;
    }
}