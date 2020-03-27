<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use Bitrix\Main\Context;
use Bitrix\Main\Diag\Debug;
use CBitrixComponent;
use CIBlock;
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

    public function getActionAdd(): string
    {
        return CIBlock::GetPanelButtons(
            $this->component->arParams['IBLOCK_CATALOG_ID']
        )['edit']['add_element']['ACTION_URL'];
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

    private function getActionUrls(array $product): array
    {
        $panelButtons = CIBlock::GetPanelButtons(
            $product['IBLOCK_ID'],
            $product['ID'],
            $product['IBLOCK_SECTION_ID']
        )['edit'];

        return [
            'EDIT_URL' => $panelButtons['edit_element']['ACTION_URL'],
            'DELETE_URL' => $panelButtons['delete_element']['ACTION_URL']
        ];
    }

    private function makeProperties(array $product): ProductProperties
    {
        $actions = $this->getActionUrls($product);

        return new ProductProperties(
            $product['ELEMENT_PRICE'],
            $product['ELEMENT_MATERIAL'],
            $actions['EDIT_URL'],
            $actions['DELETE_URL']
        );
    }
}