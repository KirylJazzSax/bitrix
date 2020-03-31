<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use CBitrixComponent;
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

        $products = [];

        $elements = CatalogRepository::getElementsOldApi($filter, $select);

        $elements->SetUrlTemplates($this->component->arParams['DETAIL_PAGE_URL']);

        while ($element = $elements->GetNext()) {
            $products[] = $element;
        }

        return $products;
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

    public function addToManufacture(array $product, int $firmId, ManufacturingCollection $manufacturingCollection): void
    {
        if ($manufacturingCollection->exists($firmId)) {
            $manufacturing = $manufacturingCollection->getManufacturing($firmId);
            if ($manufacturing->products->notExists($product['ID'])) {
                $manufacturing->products->addProduct($this->makeProduct($product));
            }
            return;
        }

        $manufacturingCollection->add(
            $this->makeManufacturing($product, $firmId)
        );
    }

    public function fillPricesCollection(CollectionInterface $collection): PricesCollection
    {
        $prices = new PricesCollection();

        foreach ($collection->getAll() as $item) {
            foreach ($item->products->getAll() as $element) {
                $prices->add(
                    new Price($element->id, $element->props->price)
                );
            }
        }

        return $prices;
    }

    private function makeProduct(array $product): Product
    {
        return new Product($product['ID'], $product['NAME'], $this->makeProperties($product));
    }

    private function makeProductsCollection(array $product): ProductsCollection
    {
        $productsCollection = new ProductsCollection();
        $productsCollection->addProduct($this->makeProduct($product));
        return $productsCollection;
    }

    private function makeManufacturing(array $product, int $firmId): Manufacturing
    {
        $name = CatalogRepository::getNameElement($firmId);
        return new Manufacturing($firmId, $name, $this->makeProductsCollection($product));
    }
}