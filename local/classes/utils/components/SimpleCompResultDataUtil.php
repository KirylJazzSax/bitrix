<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductsCollection;

class SimpleCompResultDataUtil
{
    private $manufacturingCollection;
    private $productsCollection;

    public function __construct(ManufacturingCollection $manufacturingCollection, ProductsCollection $productsCollection)
    {
        $this->manufacturingCollection = $manufacturingCollection;
        $this->productsCollection = $productsCollection;
    }

    public function prepareDataArResult(): array
    {
        $result = [];

        /** @var Manufacturing $manufacturing */
        foreach ($this->manufacturingCollection->getAllManufacturing() as $manufacturing) {
            /** @var Product $product */
            foreach ($this->productsCollection->getProducts() as $product) {
                $this->setElementArResult($manufacturing, $product, $result);
            }
        }
        return $result;
    }

    private function setElementArResult(Manufacturing $manufacturing, Product $product, array &$result): void
    {
        if (in_array($manufacturing->id, $product->props->firm)) {
            $result[$manufacturing->id]['manufacturing'] = $manufacturing;
            $result[$manufacturing->id]['products'][] = $product;
        }
    }
}