<?php

use Local\Classes\Collections\Product\PricesCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductsCollection;
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

        $this->setResultIncludeComponent(
            $this->makeProductsCollection($this->helper->getProducts())
        );

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
    }

    private function makeProductsCollection(array $products): ProductsCollection
    {
        $productsCollection = new ProductsCollection();

        foreach ($products as $product) {
            $props = $this->helper->makeProperties($product);

            $this->helper->setFirmNamesToProps($props, $this->helper->getFirmNames($props->firm));

            $productsCollection->addProduct(
                new Product($product['ID'], $product['NAME'], $props)
            );
        }

        return $productsCollection;
    }

    private function setResultIncludeComponent(ProductsCollection $productsCollection)
    {
        /** @var PricesCollection $prices */
        $prices = $this->helper->fillPricesCollection($productsCollection);

        $this->arResult['MAX_PRICE'] = $prices->getMaxPrice();
        $this->arResult['MIN_PRICE'] = $prices->getMinPrice();
        $this->arResult['PRODUCTS_COLLECTION'] = $productsCollection;
        $this->arResult['PRODUCTS_COUNT'] = $productsCollection->count();

        $this->includeComponentTemplate();
    }
}