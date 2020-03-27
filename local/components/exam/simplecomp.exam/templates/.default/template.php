<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Section\Section;
use Local\Classes\Collections\Section\SectionsCollection;

/** @var SectionsCollection $sectionCollection */
$sectionCollection = $arResult['SECTION_COLLECTION'];
/** @var $this CBitrixComponent */
?>

<div>
    <? /** @var $section Section */ ?>
    <p>Фильтр: <a href="/ex2/simplecomp/?F=Y">/ex2/simplecomp/?F=Y</a></p>
    <?php foreach ($sectionCollection->getSections() as $section): ?>
        <ul>
            <li>
                <strong><?= $section->name ?></strong>
                <ul>
                    <? /** @var $product Product */ ?>
                    <?php foreach ($section->products->getProducts() as $product): ?>
                        <?php $this->addEditAction($product->id, $product->props->editElementUrl) ?>
                        <?php $this->addDeleteAction($product->id, $product->props->deleteElementUrl) ?>
                        <li id="<?= $this->getEditAreaId($product->id) ?>">
                            <?= $product->name ?> -
                            <?= $product->props->price ?> -
                            <?= $product->props->material ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    <?php endforeach; ?>
</div>