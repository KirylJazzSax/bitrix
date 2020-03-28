<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
    "exam:simplecomp.exam",
    "prices",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_CATALOG_ID" => "2",
        "PRICE_PROPERTY_ID" => "2",
        "MATERIAL_PROPERTY_ID" => "7",
    ),
    false
);?>