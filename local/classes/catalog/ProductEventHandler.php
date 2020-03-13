<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13.03.2020
 * Time: 15:24
 */

namespace Local\Classes\Catalog;

class ProductEventHandler
{
    public function onBeforeUpdate(array $arFields): bool
    {
        $counter = ProductHelper::getCounter($arFields['ID']);

        if ($counter > 2 && $arFields['ACTIVE'] === "N") {
            global $APPLICATION;
            $APPLICATION->ThrowException("Товар невозможно деактивировать, у него $counter просмотров");
            return false;
        }
        return true;
    }
}