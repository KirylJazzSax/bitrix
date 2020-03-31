<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductsCollection;

/** @var ProductsCollection $productsCollection */
$productsCollection = $arResult['PRODUCTS_COLLECTION'];
?>

<div>
    <h3>Каталог</h3>
    <?= $arResult['NAV_STRING'] ?>
    <? /** @var $product  Product */ ?>
    <?php foreach ($productsCollection->getAll() as $product): ?>
        <ul>
            <li>
                <strong><?= $product->props->firmNames ?></strong>
                <ul>
                    <li>
                        <?= $product->name ?> -
                        <?= $product->props->price ?> -
                        <?= $product->props->material ?> -
                        <?= $product->props->artNumber ?>
                        (<?= $product->props->detailUrl ?>)
                    </li>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
    <p>Элементов на странице: <?= $productsCollection->count()?></p>
</div>