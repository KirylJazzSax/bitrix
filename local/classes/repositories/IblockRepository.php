<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2020
 * Time: 16:18
 */

namespace Local\Classes\Repositories;


use CIBlock;

class IblockRepository
{
    public static function getType(int $id): string
    {
        return CIBlock::GetByID($id)->Fetch()['IBLOCK_TYPE_ID'];
    }
}