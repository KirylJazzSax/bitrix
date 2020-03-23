<?php

use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Collections\Product\ProductsCollection;
use Local\Classes\Repositories\CatalogRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');



/**
 * Class ElementPropertyTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> IBLOCK_PROPERTY_ID int mandatory
 * <li> IBLOCK_ELEMENT_ID int mandatory
 * <li> VALUE string mandatory
 * <li> VALUE_TYPE enum ('text', 'html') optional default 'text'
 * <li> VALUE_ENUM int optional
 * <li> VALUE_NUM double optional
 * <li> DESCRIPTION string(255) optional
 * <li> IBLOCK_ELEMENT reference to {@link \Bitrix\Iblock\IblockElementTable}
 * <li> IBLOCK_PROPERTY reference to {@link \Bitrix\Iblock\IblockPropertyTable}
 * </ul>
 *
 * @package Bitrix\Iblock
 **/

class ElementPropertyTable extends \Bitrix\Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_iblock_element_property';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => 'id prop',
            ),
            'IBLOCK_PROPERTY_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'iblock id',
            ),
            'IBLOCK_ELEMENT_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => 'iblock element id',
            ),
            'VALUE' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => 'value',
            ),
            'VALUE_TYPE' => array(
                'data_type' => 'enum',
                'values' => array('text', 'html'),
                'title' => 'type of value',
            ),
            'VALUE_ENUM' => array(
                'data_type' => 'integer',
                'title' => 'enum field',
            ),
            'VALUE_NUM' => array(
                'data_type' => 'float',
                'title' => 'mun value',
            ),
            'DESCRIPTION' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateDescription'),
                'title' => 'description',
            ),
            'IBLOCK_ELEMENT' => array(
                'data_type' => 'Bitrix\Iblock\IblockElement',
                'reference' => array('=this.IBLOCK_ELEMENT_ID' => 'ref.ID'),
            ),
            'IBLOCK_PROPERTY' => array(
                'data_type' => 'Bitrix\Iblock\IblockProperty',
                'reference' => array('=this.IBLOCK_PROPERTY_ID' => 'ref.ID'),
            ),
        );
    }
    /**
     * Returns validators for DESCRIPTION field.
     *
     * @return array
     */
    public static function validateDescription()
    {
        return array(
            new \Bitrix\Main\Entity\Validator\Length(null, 255),
        );
    }

    public static function getMultipleProps(int $iblockId, int $elementId)
    {
        return self::getList(['filter' => ['IBLOCK_ELEMENT_ID' => 2]])->fetchAll();
    }
}


class SimpleComponentExam extends CBitrixComponent
{
    const CATALOG_ID_KEY = 'IBLOCK_CATALOG_ID';

    private $catalogRepository;

    public function __construct(?CBitrixComponent $component = null)
    {
        $this->catalogRepository = new CatalogRepository();

        parent::__construct($component);
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $manufacturingCollection = $this->prepareManufacturingCollection();
        $productsCollection = $this->prepareProductsCollection();

        $data = new SimpleCompResultDataUtil($manufacturingCollection, $productsCollection);

        $el = \Bitrix\Iblock\ElementTable::getList([
            'filter' => ['IBLOCK_ID' => 1, 'ID' => 2],
            'runtime' => [
                new \Bitrix\Main\Entity\ReferenceField(
                    'PROPERTY',
                    ElementPropertyTable::class,
                    \Bitrix\Main\ORM\Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                )
            ],
            'select' => ['*', 'PROPERTY_VALUE' => 'PROPERTY.VALUE', 'PROP_ID' => 'PROPERTY.ID']
        ])->fetchAll();

        \Bitrix\Main\Diag\Debug::dump($el);
//        \Bitrix\Main\Diag\Debug::dump(ElementPropertyTable::getList(['filter' => ['IBLOCK_ELEMENT_ID' => 2]])->fetch());
        global $USER;
//        \Bitrix\Main\Diag\Debug::dump(\Bitrix\Main\UserTable::getByPrimary($USER->GetID(), ['select' => ['*', 'UF_AUTHOR_TYPE']])->fetch());

        $this->arResult['DATA'] = $data->prepareDataArResult();
        $this->arResult['MANUFACTURING_COUNT'] = $manufacturingCollection->countManufacturing();

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
        $this->includeComponentTemplate();
    }

    private function prepareManufacturingCollection(): ManufacturingCollection
    {
        $manufacturingCollection = new ManufacturingCollection();

        foreach ($this->catalogRepository->getElementsIblockManufacturing() as $item) {
            if ($this->canRead($item)) {
                $manufacturingCollection->add(
                    new Manufacturing($item['ID'], $item['NAME'])
                );
            }
        }
        return $manufacturingCollection;
    }

    private function prepareProductsCollection(): ProductsCollection
    {
        $productsCollection = new ProductsCollection();

        foreach ($this->catalogRepository->getProductsByProp(ProductProperties::FIRM_PROPERTY_CODE) as $product) {
            if ($this->canRead($product)) {
                $productProps = $this->prepareProperties($product);
                $productsCollection->addProduct(
                    new Product($product['ID'], $product['NAME'], $productProps)
                );
            }
        }

        return $productsCollection;
    }

    private function prepareProperties(array $product): ProductProperties
    {
        $price = $this->catalogRepository->getPropertyProductByCode(
            $product['ID'],
            ProductProperties::PRICE_PROPERTY_CODE
        );

        $material = $this->catalogRepository->getPropertyProductByCode(
            $product['ID'],
            ProductProperties::MATERIAL_PROPERTY_CODE
        );

        $artNumber = $this->catalogRepository->getPropertyProductByCode(
            $product['ID'],
            ProductProperties::ARTNUMBER_PROPERTY_CODE
        );

        $firm = $this->catalogRepository->getMultiplePropertyByCode(
            $product['ID'],
            ProductProperties::FIRM_PROPERTY_CODE
        );

        $product[ProductProperties::DETAIL_URL_KEY] = CIBlock::ReplaceDetailUrl(
            $product[ProductProperties::DETAIL_URL_KEY],
            $product,
            false,
            'E'
        );

        return new ProductProperties($price, $material, $artNumber, $firm, $product['DETAIL_PAGE_URL']);
    }

    private function canRead(array $element): bool
    {
        return CIBlockElementRights::UserHasRightTo($element['IBLOCK_ID'], $element['ID'], 'element_read');
    }

    private function setCacheByGroup()
    {
        if ($this->arParams['CACHE_GROUPS'] === "Y") {
            // делаем что-нибудь
        }
    }
}


