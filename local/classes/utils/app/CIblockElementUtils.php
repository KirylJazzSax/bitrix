<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 17:26
 */

namespace Local\Classes\Utils\App;

use CIBlockElement;

class CIblockElementUtils
{
    public static function getProperty(int $idElement, string $propName, int $idIBlock)
    {
        $property = CIBlockElement::GetProperty(
            $idIBlock,
            $idElement,
            'sort',
            'asc',
            ['NAME' => $propName]
        )->Fetch();
        return $property['VALUE'];
    }

    public static function getPropByCode(int $idElement, string $propCode, int $idIBlock)
    {
        $property = CIBlockElement::GetProperty(
            $idIBlock,
            $idElement,
            'sort',
            'asc',
            ['CODE' => $propCode]
        )->Fetch();
        return $property['VALUE'];
    }
}