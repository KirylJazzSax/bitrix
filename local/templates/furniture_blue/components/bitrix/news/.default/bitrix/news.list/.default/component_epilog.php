<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

\Bitrix\Main\Loader::includeModule('newsutils');
use Local\NewsUtils\NewsUtils;

if ($arResult[NewsUtils::FIRST_NEWS_KEY]) {
    $APPLICATION->SetPageProperty('specialdate', $arResult[NewsUtils::FIRST_NEWS_KEY]);
}
?>