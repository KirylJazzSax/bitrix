<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Local\Classes\Collections\Manufacturing\Manufacturing;
use Local\Classes\Collections\Manufacturing\ManufacturingCollection;
use Local\Classes\Collections\Product\Product;
/** @var ManufacturingCollection $manufacturingCollection */
$manufacturingCollection = $arResult['MANUFACTURING_COLLECTION'];
?>

<div>
    <h3>Каталог</h3>
    <? /** @var $manufacturing  Manufacturing */ ?>
    <?php foreach ($manufacturingCollection->getAll() as $manufacturing): ?>
        <ul>
            <li>
                <strong><?= $manufacturing->name ?></strong>
                <ul>
                    <? /** @var $product Product */ ?>
                    <?php foreach ($manufacturing->products->getAll() as $product): ?>
                        <li>
                            <?= $product->name ?> -
                            <?= $product->props->price ?> -
                            <?= $product->props->material ?> -
                            <?= $product->props->artNumber ?>
                            (<?= $product->props->detailUrl ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
</div>