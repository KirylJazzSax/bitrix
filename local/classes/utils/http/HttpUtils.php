<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.04.2020
 * Time: 12:39
 */

namespace Local\Classes\Utils\Http;


use Bitrix\Main\Context;

class HttpUtils
{
    public static function isAjax(): bool
    {
        return Context::getCurrent()->getRequest()->isAjaxRequest();
    }

    public static function getQuery(string $name)
    {
        return Context::getCurrent()->getRequest()->getQuery($name);
    }
}