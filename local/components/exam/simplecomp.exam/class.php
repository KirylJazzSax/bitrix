<?php

use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
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
            $this->makeManufactureCollection($this->helper->getProducts())
        );

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
    }

    private function makeManufactureCollection(array $products): ManufacturingCollection
    {
        $manufacturingCollection = new ManufacturingCollection();

        foreach ($products as $product) {
            foreach ($product['PROPERTY_FIRM_VALUE'] as $firmId) {
                if ($this->canReadUser($product)) {
                    $this->helper->addToManufacture($product, $firmId, $manufacturingCollection);
                }
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