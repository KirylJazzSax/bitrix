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
        "IBLOCK_MANUFACTURING_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с классификатором",
            "TYPE" => "STRING",
            "DEFAULT" => 7
        ),
        "DETAIL_PAGE_URL" => array(
            "PARENT" => "URL_TEMPLATES",
            "NAME" => "Шаблон ссылки на детальный просмотр товара",
            "TYPE" => "STRING",
            "DEFAULT" => '/catalog_exam/#SECTION_ID#/#ELEMENT_CODE#.php'
        ),
        "CODE_PROP_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => "Код свойства товара, в котором хранится привязка товара к классификатору",
            "TYPE" => "STRING",
            "DEFAULT" => "FIRM",
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