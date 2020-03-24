<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Local\Classes\Collections\Product\Product;
?>
<div>
    <h3>Каталог</h3>
    <?php foreach ($arResult['DATA'] as $item): ?>
        <ul>
            <li>
                <strong><?= $item['manufacturing']->name ?></strong>
                <ul>
                    <? /** @var $product Product */ ?>
                    <?php foreach ($item['products'] as $product): ?>
                        <li>
                            <a href="<?= $product->props->detailUrl ?>">
                                <?= $product->name ?> -
                                <?= $product->props->price ?> -
                                <?= $product->props->material ?> -
                                <?= $product->props->artNumber ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
</div>