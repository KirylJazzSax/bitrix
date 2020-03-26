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
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
    )
);
?>