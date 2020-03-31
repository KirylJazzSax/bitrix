<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2020
 * Time: 12:57
 */

namespace Local\Classes\EventHandlers\Catalog;


use Bitrix\Main\Diag\Debug;

class ServicesEventHandler
{
    const IBLOCK_SERVICES_ID = 3;

    public function clearCacheOnElementUpdate(array &$arFields)
    {
        if ($arFields['IBLOCK_ID'] == self::IBLOCK_SERVICES_ID) {
            BXClearCache(true, '/s1/exam/');
        }
    }
}