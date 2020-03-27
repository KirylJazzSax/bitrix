<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use Bitrix\Main\Context;
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


    public function addToSection($product, SectionsCollection $sectionCollection): void
    {
        if ($sectionCollection->notExists($product['IBLOCK_SECTION_ID'])) {
            $sectionCollection->addSection(
                new Section(
                    $product['IBLOCK_SECTION_ID'],
                    $product['SECTION_NAME'],
                    $this->prepareProductCollection($product)
                )
            );
            return;
        }
        $this->addProductToSection($sectionCollection, $product);

    }

    public function getQueryFilter(): string
    {
        return Context::getCurrent()->getRequest()->getQuery('F') ?: '';
    }

    public function isFilterSet(): bool
    {
        return $this->getQueryFilter() === 'Y' ? true : false;
    }

    public function getFilterForProducts(): array
    {
        return [
            'LOGIC' => 'OR',
            [
                ['<=ELEMENT_PRICE' => 1700],
                ['=ELEMENT_MATERIAL' => 'дерево, ткань']
            ],
            [
                ['<=ELEMENT_PRICE' => 1500],
                ['=ELEMENT_MATERIAL' => 'металл, пластик']
            ],
        ];
    }

    private function addProductToSection(SectionsCollection $sectionCollection, array $product): void
    {
        if ($this->notExistsProductInSection($sectionCollection, $product)) {
            $sectionCollection
                ->getSection($product['IBLOCK_SECTION_ID'])
                ->products
                ->addProduct($this->makeProduct($product));
        }
    }

    private function notExistsProductInSection(SectionsCollection $sectionCollection, array $product): bool
    {
        return $sectionCollection->getSection($product['IBLOCK_SECTION_ID'])->products->notExists($product['ID']);
    }

    private function prepareProductCollection(array $product): ProductsCollection
    {
        $productCollection = new ProductsCollection();
        $productCollection->addProduct($this->makeProduct($product));
        return $productCollection;
    }

    private function makeProduct(array $product): Product
    {
        return new Product($product['ID'], $product['NAME'], $this->makeProperties($product));
    }

    private function makeProperties(array $product): ProductProperties
    {
        return new ProductProperties(
            $product['ELEMENT_PRICE'],
            $product['ELEMENT_MATERIAL']
        );
    }
}