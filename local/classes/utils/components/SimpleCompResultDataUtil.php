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
use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
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
        if ($manufacturingCollection->exists($product['FIRM_ID'])) {
            $manufacturing = $manufacturingCollection->getManufacturing($product['FIRM_ID']);
            if ($manufacturing->products->notExists($product['ID'])) {
                $manufacturing->products->addProduct($this->makeProduct($product));
            }
            return;
        }

        $this->setManufacturing($product, $manufacturingCollection);
    }

    private function setManufacturing(array $product, ManufacturingCollection $manufacturingCollection): void
    {
        $productCollection = new ProductsCollection();
        $productCollection->addProduct($this->makeProduct($product));
        $manufacturingCollection->add(
            new Manufacturing($product['FIRM_ID'], $product['FIRM_NAME'], $productCollection)
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
        $properties = $this->propsArrayCodeValue($this->component->getProductProps($product['ID']));

        return new ProductProperties(
            $properties[ProductProperties::PRICE_PROPERTY_CODE],
            $properties[ProductProperties::MATERIAL_PROPERTY_CODE],
            $properties[ProductProperties::ARTNUMBER_PROPERTY_CODE],
            $properties[ProductProperties::FIRM_PROPERTY_CODE],
            $product[ProductProperties::DETAIL_URL_KEY]
        );
    }

    private function propsArrayCodeValue(array $productProps): array
    {
        $properties = [];
        foreach ($productProps as $prop) {
            if (isset($properties[$prop['PROPERTY_CODE']])) {
                $properties[$prop['PROPERTY_CODE']] = [$properties[$prop['PROPERTY_CODE']]];
                $properties[$prop['PROPERTY_CODE']][] = $prop['VALUE'];
            } else {
                $properties[$prop['PROPERTY_CODE']] = $prop['VALUE'];
            }
        }

        return $properties;
    }
}