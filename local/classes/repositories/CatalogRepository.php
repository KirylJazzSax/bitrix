<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:04
 */

namespace Local\Classes\Repositories;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Query\Result;
use CIBlockElement;
use Local\Classes\Entities\ElementPropertyTable;

class CatalogRepository
{

    public static function getElements(array $filter, array $select = ['*'], array $runtime = null, array $order = null)
    {
        return ElementTable::getList([
            'filter' => $filter,
            'runtime' => $runtime,
            'select' => $select,
            'order' => $order
        ])->fetchAll();
    }

    public static function getElementProperties(array $filter = null, array $select = ['*'], array $runtime = null)
    {
        return ElementPropertyTable::getList([
            'select' => $select,
            'filter' => $filter,
            'runtime' => $runtime
        ])->fetchAll();
    }

}