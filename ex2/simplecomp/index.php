<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?$APPLICATION->IncludeComponent(
	"exam:simplecomp.exam", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_PROP_FIRM" => "FIRM",
		"DETAIL_PAGE_URL" => "#SITE_DIR#/products/#SECTION_ID#/#ID#/",
		"IBLOCK_CATALOG_ID" => "2",
		"IBLOCK_MANUFACTURING_ID" => "7",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_GROUPS" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>