<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:07
 */

namespace Local\Classes\Repositories;

use Bitrix\Iblock\ElementTable;

class NewsRepository
{
    public static function getNews($select, $filter, $runtime)
    {
        return ElementTable::getList(['filter' => $filter, 'runtime' => $runtime, 'select' => $select, ])->fetchAll();
    }
}
