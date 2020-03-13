<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Loader::includeModule('newsutils');
$newsUtils = new \Local\NewsUtils\NewsUtils($this->__component, $APPLICATION);

if ($newsUtils->canSetPageProperty()) {
    $newsUtils->setCacheKeyFirstNews();
}
?>