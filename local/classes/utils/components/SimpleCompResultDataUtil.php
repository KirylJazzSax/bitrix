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

class SimpleCompResultDataUtil
{
    private $component;

    public function __construct(CBitrixComponent $component)
    {
        $this->component = $component;
    }

    public function addProductToManufacturing(array $product, ManufacturingCollection $manufacturingCollection): void
    {
        if ($manufacturingCollection->exists($product['PROPERTY_FIRM_VALUE'])) {
            $manufacturing = $manufacturingCollection->getManufacturing($product['PROPERTY_FIRM_VALUE']);
            if ($manufacturing->products->notExists($product['ID'])) {
                $manufacturing->products->addProduct($this->makeProduct($product));
            }
            return;
        }
        $this->setManufacturing($product, $manufacturingCollection);
    }

    public function fillPricesCollection(CollectionInterface $collection): CollectionInterface
    {
        $prices = new PricesCollection();

        foreach ($collection->getAll() as $c) {
            foreach ($c->products->getAll() as $product) {
                $prices->add(
                    new Price($product->id, $product->props->price)
                );
            }
        }
        return $prices;
    }

    private function setManufacturing(array $product, ManufacturingCollection $manufacturingCollection): void
    {
        $productCollection = new ProductsCollection();
        $productCollection->addProduct($this->makeProduct($product));
        $manufacturingCollection->add(
            new Manufacturing($product['PROPERTY_FIRM_VALUE'], $product['PROPERTY_FIRM_NAME'], $productCollection)
        );
    }

    private function makeDetailUrl(array &$product): void
    {
        $product[ProductProperties::DETAIL_URL_KEY] = CIBlock::ReplaceDetailUrl(
            $product[ProductProperties::DETAIL_URL_KEY],
            $product,
            false,
            'E'
        );
    }

    private function makeProduct(array $product): Product
    {
        $product[ProductProperties::DETAIL_URL_KEY] = $this->component->arParams['DETAIL_PAGE_URL'];
        $this->makeDetailUrl($product);

        return new Product($product['ID'], $product['NAME'], $this->makeProperties($product));
    }

    private function makeProperties(array $product): ProductProperties
    {
        return new ProductProperties(
            $product['PROPERTY_PRICE_VALUE'],
            $product['PROPERTY_MATERIAL_VALUE'],
            $product['PROPERTY_ARTNUMBER_VALUE'],
            $product['FIRM']['VALUE'],
            $product['DETAIL_PAGE_URL']
        );

    }
}