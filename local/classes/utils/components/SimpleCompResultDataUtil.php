<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use CBitrixComponent;
use CIBlock;
use Local\Classes\Collections\Interfaces\CollectionInterface;
use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\Price;
use Local\Classes\Collections\Product\PricesCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Collections\Product\ProductsCollection;
use Local\Classes\Repositories\CatalogRepository;

class SimpleCompResultDataUtil
{
    private $component;

    public function __construct(CBitrixComponent $component)
    {
        $this->component = $component;
    }

    public function setFirmNamesToProps(ProductProperties $props, $names): void
    {
        $props->firmNames = implode(', ', $names);
    }

    public function getProducts()
    {
        $select = [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'CODE',
            'PROPERTY_FIRM',
            'PROPERTY_PRICE',
            'PROPERTY_MATERIAL',
            'PROPERTY_ARTNUMBER',
            'DETAIL_PAGE_URL'
        ];

        $filter = [
            '!PROPERTY_FIRM' => false
        ];

        $navParams = [
            'nPageSize' => $this->component->arParams['ELEMENTS_PER_PAGE']
        ];

        $products = [];

        $elements = CatalogRepository::getElementsOldApi($filter, $select, $navParams);

        $this->setNavString(
            $elements->GetPageNavStringEx($navComponentObject, 'Странички')
        );
        $elements->SetUrlTemplates($this->component->arParams['DETAIL_PAGE_URL']);

        while ($element = $elements->GetNext()) {
            $products[] = $element;
        }

        return $products;
    }

    public function getFirmNames(array $idsFirm): array
    {
        $names = [];

        $filter = [
            'ID' => $idsFirm
        ];

        $select = [
            'NAME'
        ];

        $elements = CatalogRepository::getElementsOldApi($filter, $select);

        while ($element = $elements->GetNext()) {
            $names[] = $element['NAME'];
        }

        return $names;
    }

    public function fillPricesCollection(CollectionInterface $collection): CollectionInterface
    {
        $prices = new PricesCollection();

        foreach ($collection->getAll() as $element) {
                $prices->add(
                    new Price($element->id, $element->props->price)
                );
        }
        return $prices;
    }

    public function makeProperties(array $product): ProductProperties
    {
        return new ProductProperties(
            $product['PROPERTY_PRICE_VALUE'],
            $product['PROPERTY_MATERIAL_VALUE'],
            $product['PROPERTY_ARTNUMBER_VALUE'],
            $product['PROPERTY_FIRM_VALUE'],
            $product['DETAIL_PAGE_URL']
        );

    }

    private function setNavString(string $navString): void
    {
        $this->component->arResult['NAV_STRING'] = $navString;
    }
}