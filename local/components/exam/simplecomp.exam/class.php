<?php

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Entities\ElementPropertyTable;
use Local\Classes\Repositories\CatalogRepository;
use Local\Classes\Repositories\UserRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');

class SimpleComponentExam extends CBitrixComponent
{
    private $userRepository;
    private $helper;

    public function __construct(?CBitrixComponent $component = null)
    {
        global $USER;
        $this->userRepository = new UserRepository($USER);
        $this->helper = new SimpleCompResultDataUtil($this);

        parent::__construct($component);
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $this->setCacheByGroupIncludeComponent(
            $this->makeManufacturingCollection($this->getProductsOrderedByFirm())
        );

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
    }

    public function getProductsOrderedByFirm()
    {
        $select = [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'CODE',
            'PROP_VALUE' => 'PROPERTY.VALUE',
            'PROP_CODE' => 'PROP.CODE',
            'FIRM_ID' => 'FIRM.ID',
            'FIRM_NAME' => 'FIRM.NAME',
            'FIRM_IBLOCK' => 'FIRM.IBLOCK_ID',
        ];

        $filter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
            '=FIRM_IBLOCK' => $this->arParams['IBLOCK_MANUFACTURING_ID'],
        ];

        $runtime = [
            new ReferenceField(
                'PROPERTY',
                ElementPropertyTable::class,
                Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ),
            new ReferenceField(
                'PROP',
                PropertyTable::class,
                array(
                    '=this.PROPERTY.IBLOCK_PROPERTY_ID' => 'ref.ID'
                ),
                array('join_type' => 'LEFT')
            ),
            new ReferenceField(
                'FIRM',
                ElementTable::class,
                Join::on('this.PROP_VALUE', 'ref.ID')
            )
        ];

        $order = [
            'NAME' => 'asc',
            'SORT' => 'asc'
        ];

        return CatalogRepository::getElements($filter, $select, $runtime, $order);
    }

    public function getProductProps(int $idProduct)
    {
        $select = [
            'ID',
            'VALUE',
            'IBLOCK_PROPERTY_ID',
            'IBLOCK_ELEMENT_ID',
            'ELEMENT_ID' => 'ELEMENT.ID',
            'PROPERTY_NAME' => 'PROPERTY.NAME',
            'PROPERTY_CODE' => 'PROPERTY.CODE'
        ];

        $filter = [
            '=ELEMENT_ID' => $idProduct,
            '=PROPERTY_CODE' => [
                $this->arParams['CODE_PROP_FIRM'],
                ProductProperties::PRICE_PROPERTY_CODE,
                ProductProperties::MATERIAL_PROPERTY_CODE,
                ProductProperties::ARTNUMBER_PROPERTY_CODE
            ]
        ];

        $runtime = [
            new ReferenceField(
                'ELEMENT',
                ElementTable::class,
                Join::on('this.IBLOCK_ELEMENT_ID', 'ref.ID')
            ),
            new ReferenceField(
                'PROPERTY',
                PropertyTable::class,
                Join::on('this.IBLOCK_PROPERTY_ID', 'ref.ID')
            )
        ];

        return CatalogRepository::getElementProperties($filter, $select, $runtime);
    }

    private function makeManufacturingCollection(array $products)
    {
        $manufacturingCollection = new ManufacturingCollection();

        foreach ($products as $product) {
            if ($this->canReadUser($product)) {
                $this->helper->addProductToManufacturing($product, $manufacturingCollection);
            }
        }
        return $manufacturingCollection;
    }

    private function canReadUser(array $element): bool
    {
        return CIBlockElementRights::UserHasRightTo($element['IBLOCK_ID'], $element['ID'], 'element_read');
    }

    private function setCacheByGroupIncludeComponent(ManufacturingCollection $manufacturingCollection)
    {
        if ($this->startResultCache(false, $this->userRepository->getGroupsString())) {
            $this->arResult['MANUFACTURING_COLLECTION'] = $manufacturingCollection;
            $this->arResult['MANUFACTURING_COUNT'] = $manufacturingCollection->countManufacturing();

            $this->includeComponentTemplate();
        }
    }
}