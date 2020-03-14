<?php

namespace Local\Classes\Utils\Catalog;

use CIBlockElement;

class ProductHelper
{
    public static function getCounter(int $productId)
    {
        return CIBlockElement::GetList([], ['ID' => $productId])->GetNext()['SHOW_COUNTER'];
    }
}