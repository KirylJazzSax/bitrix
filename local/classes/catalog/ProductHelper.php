<?php

namespace Local\Classes\Catalog;

use CIBlockElement;

class ProductHelper
{
    public static function getCounter(int $productId)
    {
        return CIBlockElement::GetList([], ['ID' => $productId])->GetNext()['SHOW_COUNTER'];
    }
}