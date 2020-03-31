<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:04
 */

namespace Local\Classes\Repositories;

use Bitrix\Iblock\ElementTable;
use CIBlockElement;
use CIBlockResult;
use Local\Classes\Entities\ElementPropertyTable;

class CatalogRepository
{

    public static function getElements(array $filter, array $select = ['*'], array $runtime = [], array $order = [])
    {
        return ElementTable::getList([
            'filter' => $filter,
            'runtime' => $runtime,
            'select' => $select,
            'order' => $order
        ])->fetchAll();
    }

    public static function getElementProperties(array $filter, array $select = ['*'], array $runtime = [])
    {
        return ElementPropertyTable::getList([
            'select' => $select,
            'filter' => $filter,
            'runtime' => $runtime
        ])->fetchAll();
    }

    public static function getElementsOldApi($filter, $select, $navParams = false): CIBlockResult
    {
        return CIBlockElement::GetList(false, $filter, false, $navParams, $select);
    }

}