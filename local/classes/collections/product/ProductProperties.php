<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.03.2020
 * Time: 18:57
 */

namespace Local\Classes\Collections\Product;


class ProductProperties
{
    const PRICE_PROPERTY_CODE = 'PRICE';
    const MATERIAL_PROPERTY_CODE = 'MATERIAL';

    public $price;
    public $material;

    public function __construct(int $price, string $material)
    {
        $this->price = $price;
        $this->material = $material;
    }
}