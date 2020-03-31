<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
    "exam:simplecomp.exam",
    "prices",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_CATALOG_ID" => "2",
        "IBLOCK_MANUFACTURING_ID" => "7",
        "ELEMENTS_PER_PAGE" => "2",
        "CODE_PROP_FIRM" => "FIRM",
        "DETAIL_PAGE_URL" => "/catalog_exam/#SECTION_ID#/#ELEMENT_CODE#.php",
        "CACHE_GROUPS" => "Y"
    ),
    false
);?>