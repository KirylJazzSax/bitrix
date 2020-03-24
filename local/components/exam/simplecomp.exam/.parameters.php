<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;

\Bitrix\Main\Loader::includeModule('iblock');

$newsId = IblockTable::getList(['select' => ['ID'], 'filter' => ['CODE' => 'furniture_news_s1']])->fetch()['ID'];
$codeProp = PropertyTable::getByPrimary(13)->fetch()['CODE'];
$userFiled = \Bitrix\Main\UserFieldTable::getByPrimary(10)->fetch()['FIELD_NAME'];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_NEWS_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID информационного блока с новостями",
            "TYPE" => "STRING",
            "DEFAULT" => $newsId
        ),
        "CODE_NEWS_PROP_AUTHOR" => array(
            "PARENT" => "BASE",
            "NAME" => " Код свойства информационного блока, в котором хранится Автор",
            "TYPE" => "STRING",
            "DEFAULT" => $codeProp
        ),
        "CODE_USER_FIELD_AUTHOR" => array(
            "PARENT" => "URL_TEMPLATES",
            "NAME" => "Код пользовательского свойства пользователей, в котором хранится тип автора",
            "TYPE" => "STRING",
            "DEFAULT" => $userFiled
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
    )
);
?>