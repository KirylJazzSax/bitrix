<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?$APPLICATION->IncludeComponent(
    "exam:simplecomp.exam",
    ".default",
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
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>