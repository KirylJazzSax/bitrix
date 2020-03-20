<?php

use Local\Classes\Collections\News\News;
use Local\Classes\Collections\News\NewsCollection;
use Local\Classes\Collections\Product\Product;
use Local\Classes\Collections\Product\ProductsCollection;
use Local\Classes\Collections\Section\Section;
use Local\Classes\Collections\Section\SectionsCollection;
use Local\Classes\Repositories\CatalogRepository;
use Local\Classes\Repositories\NewsRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');


class SimpleComponentExam extends CBitrixComponent
{
    const CATALOG_ID_KEY = 'IBLOCK_CATALOG_ID';

    private $catalogRepository;
    private $newsRepository;

    public function __construct(?CBitrixComponent $component = null)
    {
        $this->catalogRepository = new CatalogRepository();
        $this->newsRepository = new NewsRepository();

        parent::__construct($component);
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $sectionsCollection = $this->prepareSectionCollection();
        $newsCollection = $this->prepareNewsCollection();

        $data = new SimpleCompResultDataUtil($newsCollection, $sectionsCollection);

        $this->arResult['DATA'] = $this->sectionNamesToString($data->prepareResultDataForComponent());
        $this->arResult['PRODUCTS_COUNT'] = $this->countAllProducts($sectionsCollection);

        $APPLICATION->SetTitle('В каталоге товаров представлено товаров: ' . $this->arResult['PRODUCTS_COUNT']);

        $this->includeComponentTemplate();
    }

    private function countAllProducts(SectionsCollection $sectionsCollection)
    {
        $counter = 0;
        /** @var Section $section */
        foreach ($sectionsCollection->getSections() as $section) {
            $counter += $section->countProducts();
        }
        return $counter;
    }

    private function sectionNamesToString($arResult): array
    {
        foreach ($arResult as &$item) {
            $names = [];
            array_walk($item['sections'], function ($section) use (&$names) {
                $names[] = $section->name;
            });
            $item['section_names'] = implode(', ', $names);
        }
        return $arResult;
    }

    private function prepareProductCollection(int $sectionId): ProductsCollection
    {
        $productsCollection = new ProductsCollection();

        foreach ($this->catalogRepository->getSectionProducts(['ID', 'NAME'], $sectionId) as $product) {

            $material = $this->catalogRepository->getPropertyProductByCode($product['ID'], 'MATERIAL');
            $price = (int)$this->catalogRepository->getPropertyProductByCode($product['ID'], 'PRICE');
            $artNumber = $this->catalogRepository->getPropertyProductByCode($product['ID'], 'ARTNUMBER');

            $product = new Product($product['ID'], $product['NAME'], $price, $material, $artNumber);
            $productsCollection->addProduct($product);
        }

        return $productsCollection;
    }

    private function prepareSectionCollection(): SectionsCollection
    {
        $sectionsCollection = new SectionsCollection();

        foreach ($this->catalogRepository->getSections(['ID', 'NAME', 'UF_NEWS_LINK']) as $section) {
            $productsCollectionBySection = $this->prepareProductCollection($section['ID']);
            $sectionsCollection->addSection(
                new Section($section['ID'], $section['NAME'], $section['UF_NEWS_LINK'], $productsCollectionBySection
                )
            );
        }

        return $sectionsCollection;
    }

    private function prepareNewsCollection()
    {
        $newsCollection = new NewsCollection();

        foreach ($this->newsRepository->getNews(['ID', 'NAME', 'ACTIVE_FROM']) as $news) {
            $newsCollection->add(new News($news['ID'], $news['NAME'], $news['ACTIVE_FROM']));
        }

        return $newsCollection;
    }
}