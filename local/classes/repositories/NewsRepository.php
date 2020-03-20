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
    const IBLOCK_NEWS_ID = 1;

    public function getNews(array $select): array
    {
        return ElementTable::getList(['select' => $select, 'filter' => ['IBLOCK_ID' => self::IBLOCK_NEWS_ID]])->fetchAll();
    }
}
