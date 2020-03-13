<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Loader::includeModule('newsutils');
$canonicalUtils = new \Local\NewsUtils\CanonicalIBlockUtils($arParams, $arResult);

if ($canonicalUtils->isInParametersIdCanonical() && $nameElement = $canonicalUtils->getNameCanonicalElement()) {
    $APPLICATION->SetDirProperty($canonicalUtils::CANONICAL_PROPERTY, $nameElement);
}
?>
