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
    public static function getProperty(int $idElement, string $propName)
    {
        $property = CIBlockElement::GetProperty(
            6,
            $idElement,
            'sort',
            'asc',
            ['NAME' => $propName]
        )->Fetch();
        return $property['VALUE'];
    }
}