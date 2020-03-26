<?php

use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Collections\Section\SectionsCollection;
use Local\Classes\Entities\ElementPropertyTable;
use Local\Classes\Repositories\CatalogRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');

class SimpleComponentExam extends CBitrixComponent
{
    private $helper;

    public function __construct(?CBitrixComponent $component = null)
    {
        $this->helper = new SimpleCompResultDataUtil($this);

        parent::__construct($component);
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $this->setCacheByGroupIncludeComponent(
            $this->makeSectionCollection($this->getProductsWithSections())
        );

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
    }

    private function makeSectionCollection($products)
    {
        $sectionCollection = new SectionsCollection();

        foreach ($products as $product) {

            $this->helper->addToSection($products, $product, $sectionCollection);
        }
        return $sectionCollection;
    }


    private function getProductsWithSections()
    {
        $select = [
            'ID',
            'NAME',
            'PROP_CODE' => 'PROP.CODE',
            'PROP_VALUE' => 'PROPERTY.VALUE',
            'IBLOCK_SECTION_ID',
            'SECTION_NAME' => 'SECTION.NAME'
        ];

        $filter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
            '=PROP_CODE' => [
                ProductProperties::PRICE_PROPERTY_CODE,
                ProductProperties::MATERIAL_PROPERTY_CODE
            ]
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
                'SECTION',
                SectionTable::class,
                Join::on('this.IBLOCK_SECTION_ID', 'ref.ID')
            )
        ];

        return CatalogRepository::getElements($filter, $select, $runtime);
    }



    private function setCacheByGroupIncludeComponent(SectionsCollection $sectionsCollection)
    {
        if ($this->startResultCache()) {
            $this->arResult['SECTION_COLLECTION'] = $sectionsCollection;

            $this->includeComponentTemplate();
        }
    }
}