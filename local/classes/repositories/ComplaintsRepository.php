<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.04.2020
 * Time: 12:41
 */

namespace Local\Classes\Repositories;


use CIBlockElement;

class ComplaintsRepository
{
    const IBLOCK_COMPLAINTS_ID = 8;

    public static function save(array $fields)
    {
        return (new CIBlockElement())->Add(
                array_merge($fields, ['IBLOCK_ID' => self::IBLOCK_COMPLAINTS_ID])
            );
    }
}