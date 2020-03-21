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
use CIBlockElement;

class CatalogRepository
{
    const IBLOCK_CATALOG_ID = 2;
    const IBLOCK_MANUFACTURING_ID = 7;

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

    public function getMultiplePropertyByCode(int $idElement, string $code): array
    {
        $propId = PropertyTable::getList(['select' => ['ID'], 'filter' => ['CODE' => $code]])->fetch()['ID'];
        $props = CIBlockElement::GetPropertyValues(self::IBLOCK_CATALOG_ID, ['ID' => $idElement])->Fetch();
        return $props[$propId];
    }

    public function getProductsByProp(string $propCode): array
    {
        $result = [];
        $products = ElementTable::getList([
            'select' => ['*', 'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'],
            'filter' => ['IBLOCK_ID' => self::IBLOCK_CATALOG_ID]
        ]);

        while ($product = $products->fetch()) {
            $prop = $this->getMultiplePropertyByCode($product['ID'], $propCode);
            if (!empty($prop)) {
                $result[] = $product;
            }
        }
        return $result;
    }

    public function getElementsIblockManufacturing(): array
    {
        return ElementTable::getList(['filter' => ['IBLOCK_ID' => self::IBLOCK_MANUFACTURING_ID]])->fetchAll();
    }
}