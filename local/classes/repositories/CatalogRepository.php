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
use CIBlockElement;

class CatalogRepository
{
    const IBLOCK_CATALOG_ID = 2;

    /**
     * @param array $select поля для оперятора SELECT
     * @return array
     */
    public function getSections(array $select): array
    {
        $entity = Section::compileEntityByIblock(self::IBLOCK_CATALOG_ID);
        return $entity::getList(['select' => $select])->fetchAll();
    }

    public function getSectionProducts(array $select, int $sectionId): array
    {
        return ElementTable::getList([
            'select' => $select,
            'filter' => ['IBLOCK_ID' => self::IBLOCK_CATALOG_ID, 'IBLOCK_SECTION_ID' => $sectionId]
        ])->fetchAll();
    }

    public function getPropertyProductByCode(int $idElement, string $code)
    {
        $property = CIBlockElement::GetProperty(
            self::IBLOCK_CATALOG_ID,
            $idElement,
            'sort',
            'asc',
            ['CODE' => $code]
        )->Fetch();
        return $property['VALUE'];
    }
}