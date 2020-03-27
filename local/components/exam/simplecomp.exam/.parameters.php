<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_CATALOG_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с каталогом товаров",
            "TYPE" => "STRING",
            "DEFAULT" => 2
        ),
        "PRICE_PROPERTY_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID свойства цена",
            "TYPE" => "STRING",
            "DEFAULT" => 2
        ),
        "MATERIAL_PROPERTY_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID свойства цена",
            "TYPE" => "STRING",
            "DEFAULT" => 7
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
    )
);
?>