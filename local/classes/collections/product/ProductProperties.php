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
    const ARTNUMBER_PROPERTY_CODE = 'ARTNUMBER';
    const FIRM_PROPERTY_CODE = 'FIRM';
    const DETAIL_URL_KEY = 'DETAIL_PAGE_URL';

    public $price;
    public $material;
    public $artNumber;
    public $firm;
    public $detailUrl;

    public function __construct(int $price, string $material, string $artNumber, array $firm, string $detailUrl)
    {
        $this->price = $price;
        $this->material = $material;
        $this->artNumber = $artNumber;
        $this->firm = $firm;
        $this->detailUrl = $detailUrl;
    }
}