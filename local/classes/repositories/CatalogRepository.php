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

    public static function getElementsWithPropsOldApi(
        array $filter = [],
        array $select = ['*'],
        array $order = [],
        array $propsFilter = []
    ): array
    {
        $result = [];
        $elements = CIBlockElement::GetList($order, $filter, false, false, $select);

        while ($element = $elements->GetNextElement()) {
            $result[] = array_merge(
                $element->GetFields(),
                $element->GetProperties(false, $propsFilter)
            );
        }

        return $result;
    }

}