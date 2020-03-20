<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Iblock\IblockTable;

\Bitrix\Main\Loader::includeModule('iblock');

$catalogId = IblockTable::getList(['select' => ['ID'], 'filter' => ['IBLOCK_TYPE_ID' => 'products']])->fetch();
$newsId = IblockTable::getList(['select' => ['ID'], 'filter' => ['IBLOCK_TYPE_ID' => 'news']])->fetch();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_CATALOG_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с каталогом товаров",
            "TYPE" => "STRING",
            "DEFAULT" => $catalogId['ID']
        ),
        "IBLOCK_NEWS_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с новостями",
            "TYPE" => "STRING",
            "DEFAULT" => $newsId['ID']
        ),
        "CODE_PROP_NEWS_LINK" => array(
            "PARENT" => "BASE",
            "NAME" => "Код пользовательского свойства разделов каталога, в котором хранится привязка к новостям",
            "TYPE" => "STRING",
            "DEFAULT" => "UF_NEWS_LINK"
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
    )
);
?>