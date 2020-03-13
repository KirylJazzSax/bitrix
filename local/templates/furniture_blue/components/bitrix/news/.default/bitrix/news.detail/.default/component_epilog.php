<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$canonicalUtils = new \Local\NewsUtils\CanonicalIBlockUtils($arParams, $arResult);

if ($canonicalUtils->isInParametersIdCanonical() && $nameElement = $canonicalUtils->getNameCanonicalElement()) {
    $APPLICATION->SetDirProperty($canonicalUtils::CANONICAL_PROPERTY, $nameElement);
}
?>
