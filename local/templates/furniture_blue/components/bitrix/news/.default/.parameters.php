<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "ID_IBLOCK_CANONICAL" => Array(
        "NAME" => GetMessage('ID_IBLOCK_REL_CANONICAL'),
        "TYPE" => "STRING",
    ),
    "COLLECT_COMPLAINTS_AJAX" => Array(
        "PARENT" => "AJAX_SETTINGS",
        "NAME" => GetMessage("COLLECT_COMPLAINTS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);
?>