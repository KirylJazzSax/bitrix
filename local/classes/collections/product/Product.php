<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:15
 */

namespace Local\Classes\Collections\Product;


class Product
{
    public $id;
    public $name;
    // Это свойства элемента
    public $price;
    public $material;
    public $artNumber;

    public function __construct(int $id, string $name, int $price, string $material, string $artNumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->material = $material;
        $this->artNumber = $artNumber;
    }
}