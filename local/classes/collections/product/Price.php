<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2020
 * Time: 17:47
 */

namespace Local\Classes\Collections\Product;


class Price
{
    public $idProduct;
    public $price;

    public function __construct(int $idProduct, int $price)
    {
        $this->idProduct = $idProduct;
        $this->price = $price;
    }
}