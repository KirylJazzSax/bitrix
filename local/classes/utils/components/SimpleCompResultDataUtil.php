<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use CBitrixComponent;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductProperties;
use Local\Classes\Collections\Product\ProductsCollection;
use Local\Classes\Collections\Section\Section;
use Local\Classes\Collections\Section\SectionsCollection;

class SimpleCompResultDataUtil
{
    private $component;

    public function __construct(CBitrixComponent $component)
    {
        $this->component = $component;
    }


    public function addToSection($products, $product, SectionsCollection $sectionCollection): void
    {
        if ($sectionCollection->notExists($product['IBLOCK_SECTION_ID'])) {
            $sectionCollection->addSection(
                new Section(
                    $product['IBLOCK_SECTION_ID'],
                    $product['SECTION_NAME'],
                    $this->prepareProductCollection($products, $product)
                )
            );
            return;
        }
        $this->addProductToSection($sectionCollection, $products, $product);

    }

    private function addProductToSection(SectionsCollection $sectionCollection, array $products, array $product): void
    {
        if ($this->notExistsProductInSection($sectionCollection, $product)) {
            $sectionCollection
                ->getSection($product['IBLOCK_SECTION_ID'])
                ->products
                ->addProduct($this->makeProduct($products, $product));
        }
    }

    private function notExistsProductInSection(SectionsCollection $sectionCollection, array $product): bool
    {
        return $sectionCollection->getSection($product['IBLOCK_SECTION_ID'])->products->notExists($product['ID']);
    }

    private function prepareProductCollection(array $products, array $product): ProductsCollection
    {
        $productCollection = new ProductsCollection();
        $productCollection->addProduct($this->makeProduct($products, $product));
        return $productCollection;
    }

    private function makeProduct(array $products, array $product): Product
    {
        return new Product($product['ID'], $product['NAME'], $this->makeProperties($products, $product));
    }

    private function makeProperties(array $products, array $current): ProductProperties
    {
        $properties = $this->propsArrayCodeValue($this->getPropsCurrentProduct($products, $current));

        return new ProductProperties(
            $properties[ProductProperties::PRICE_PROPERTY_CODE],
            $properties[ProductProperties::MATERIAL_PROPERTY_CODE]
        );
    }

    private function getPropsCurrentProduct(array $products, array $product): array
    {
        return array_filter($products, function ($element) use ($product) {
            return $element['ID'] === $product['ID'];
        });
    }

    private function propsArrayCodeValue(array $productProps): array
    {
        $properties = [];
        foreach ($productProps as $prop) {
            if (isset($properties[$prop['PROP_CODE']])) {
                $properties[$prop['PROP_CODE']] = [$properties[$prop['PROP_CODE']]];
                $properties[$prop['PROP_CODE']][] = $prop['PROP_VALUE'];
            } else {
                $properties[$prop['PROP_CODE']] = $prop['PROP_VALUE'];
            }
        }

        return $properties;
    }
}