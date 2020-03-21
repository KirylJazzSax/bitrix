<?php

use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Collections\Product\ProductsCollection;
use Local\Classes\Repositories\CatalogRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');

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

        $this->arResult['DATA'] = $data->prepareDataArResult();
        $this->arResult['MANUFACTURING_COUNT'] = $manufacturingCollection->countManufacturing();

        $APPLICATION->SetTitle('Разделов: ' . $this->arResult['MANUFACTURING_COUNT']);
        $this->includeComponentTemplate();
    }

    private function prepareManufacturingCollection(): ManufacturingCollection
    {
        $manufacturingCollection = new ManufacturingCollection();

        foreach ($this->catalogRepository->getElementsIblockManufacturing() as $item) {
            if ($this->checkAccess($item)) {
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
            if ($this->checkAccess($product)) {
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

    private function checkAccess(array $element): bool
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