<?php

use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\PricesCollection;
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
            $this->makeManufacturingCollection($this->getProductsByFirm())
        );

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
    }

    public function getProductsByFirm()
    {
        $select = [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'CODE',
            'PROPERTY_FIRM',
            'PROPERTY_FIRM.NAME',
            'PROPERTY_PRICE',
            'PROPERTY_MATERIAL',
            'PROPERTY_ARTNUMBER',
        ];

        $filter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
            '!PROPERTY_FIRM' => false
        ];

        $propsFilter = ['CODE' => $this->arParams['CODE_PROP_FIRM']];

        $order = [
            'NAME' => 'ASC',
            'SORT' => 'ASC'
        ];

        return CatalogRepository::getElementsWithPropsOldApi($filter, $select, $order, $propsFilter);
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
        /** @var PricesCollection $prices */
        $prices = $this->helper->fillPricesCollection($manufacturingCollection);

        if ($this->startResultCache(false, $this->userRepository->getGroupsString())) {
            $this->arResult['MAX_PRICE'] = $prices->getMaxPrice();
            $this->arResult['MIN_PRICE'] = $prices->getMinPrice();
            $this->arResult['MANUFACTURING_COLLECTION'] = $manufacturingCollection;
            $this->arResult['MANUFACTURING_COUNT'] = $manufacturingCollection->countManufacturing();

            $this->includeComponentTemplate();
        }
    }
}