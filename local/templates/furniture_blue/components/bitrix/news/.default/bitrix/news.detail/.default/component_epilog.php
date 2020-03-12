<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Loader::includeModule('newsutils');
$canonicalUtils = new \Local\NewsUtils\CanonicalIBlockUtils();

$nameCanonicalElement = $canonicalUtils->getNameCanonicalElement($arResult['ID']);

if ($nameCanonicalElement) {
    $APPLICATION->SetDirProperty('canonical', $nameCanonicalElement);
}
?>
