<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;

\Bitrix\Main\Loader::includeModule('iblock');

$catalogId = IblockTable::getList(['select' => ['ID'], 'filter' => ['CODE' => 'furniture_products_s1']])->fetch()['ID'];
$classifierId = IblockTable::getList(['select' => ['ID'], 'filter' => ['CODE' => 'manufacturing']])->fetch()['ID'];
$detailUrlTemplate = IblockTable::getList(['select' => ['DETAIL_PAGE_URL'], 'filter' => ['ID' => $catalogId]])->fetch()['DETAIL_PAGE_URL'];
$codeProp = PropertyTable::getByPrimary(12)->fetch()['CODE'];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_CATALOG_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с каталогом товаров",
            "TYPE" => "STRING",
            "DEFAULT" => $catalogId
        ),
        "IBLOCK_MANUFACTURING_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с классификатором",
            "TYPE" => "STRING",
            "DEFAULT" => $classifierId
        ),
        "DETAIL_PAGE_URL" => array(
            "PARENT" => "URL_TEMPLATES",
            "NAME" => "Шаблон ссылки на детальный просмотр товара",
            "TYPE" => "STRING",
            "DEFAULT" => $detailUrlTemplate
        ),
        "CODE_PROP_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => "Код свойства товара, в котором хранится привязка товара к классификатору",
            "TYPE" => "STRING",
            "DEFAULT" => $codeProp,
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => "Кеширование компонента должно ли зависеть от групп пользователей?",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y"
        )
    )
);
?>