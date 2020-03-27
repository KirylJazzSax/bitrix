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
    public $editElementUrl;
    public $deleteElementUrl;

    public function __construct(
        int $price,
        string $material,
        string $editElementUrl,
        string $deleteElementUrl
    )
    {
        $this->price = $price;
        $this->material = $material;
        $this->editElementUrl = $editElementUrl;
        $this->deleteElementUrl = $deleteElementUrl;
    }
}