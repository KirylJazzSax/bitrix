<?php

use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;
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

        $filter = $this->helper->isFilterSet() ? $this->helper->getFilterForProducts() : null;


        $this->setCacheIncludeComponent(
            $this->makeSectionCollection(
                $this->getProductsWithSections($filter)
            )
        );

        $this->addToHermitageButton();
        $APPLICATION->SetTitle('Каталог Продукция. Элементов: ');
    }

    private function addToHermitageButton(): void
    {
        $this->addIncludeAreaIcon([
            'TITLE' => 'Добавить товар',
            'URL' => $this->helper->getActionAdd(),
            'ICON' => 'bx-context-toolbar-create-icon'
        ]);
    }

    private function makeSectionCollection($products)
    {
        $sectionCollection = new SectionsCollection();

        foreach ($products as $product) {
            $this->helper->addToSection($product, $sectionCollection);
        }
        return $sectionCollection;
    }


    private function getProductsWithSections(array $filter = null)
    {
        $select = [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'SECTION_NAME' => 'SECTION.NAME',
            'ELEMENT_PRICE' => 'PRICE.VALUE',
            'ELEMENT_MATERIAL' => 'MATERIAL.VALUE',
        ];

        $filter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
            $filter
        ];

        $runtime = [
            new ReferenceField(
                'PRICE',
                ElementPropertyTable::class,
                Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                    ->where('ref.IBLOCK_PROPERTY_ID', $this->arParams['PRICE_PROPERTY_ID'])
            ),
            new ReferenceField(
                'MATERIAL',
                ElementPropertyTable::class,
                Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
                    ->where('ref.IBLOCK_PROPERTY_ID', $this->arParams['MATERIAL_PROPERTY_ID'])
            ),
            new ReferenceField(
                'SECTION',
                SectionTable::class,
                Join::on('this.IBLOCK_SECTION_ID', 'ref.ID')
            ),
        ];

        return CatalogRepository::getElements($filter, $select, $runtime);
    }

    private function setCacheIncludeComponent(SectionsCollection $sectionsCollection)
    {
        if ($this->helper->isFilterSet()) {
            $this->setArResultTemplate($sectionsCollection);
        } else {
            if ($this->startResultCache()) {
                $this->setArResultTemplate($sectionsCollection);
            }
        }
    }

    private function setArResultTemplate(SectionsCollection $sectionsCollection): void
    {
        $this->arResult['SECTION_COLLECTION'] = $sectionsCollection;
        $this->includeComponentTemplate();
    }
}