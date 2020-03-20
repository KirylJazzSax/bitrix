<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Local\Classes\Collections\Section\Section;
?>
<div>
    <h3>Каталог</h3>
    <?php foreach ($arResult['DATA'] as $item): ?>
        <ul>
            <li>
                <strong><?= $item['news']->name ?></strong> - <?= $item['news']->date ?>
                (<?= $item['section_names'] ?>)
                <ul>
                    <? /** @var $section Section */?>
                    <?php foreach ($item['sections'] as $section): ?>
                        <?php foreach ($section->products->getProducts() as $product): ?>
                            <li>
                                <?= $product->name ?> -
                                <?= $product->price ?> -
                                <?= $product->material ?> -
                                <?= $product->artNumber ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
</div>
