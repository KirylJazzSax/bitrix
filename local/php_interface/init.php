<?
CModule::AddAutoloadClasses(
    '',
    [
        'Local\\NewsUtils\\NewsUtils' => '/local/classes/NewsUtils.php',
        'Local\\NewsUtils\\CanonicalIBlockUtils' => '/local/classes/CanonicalIBlockUtils.php',
        'Local\\Classes\\Catalog\\ProductHelper' => '/local/classes/catalog/ProductHelper.php',
        'Local\\Classes\\Catalog\\ProductEventHandler' => '/local/classes/catalog/ProductEventHandler.php'
    ]
);

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    [\Local\Classes\Catalog\ProductEventHandler::class, 'onBeforeUpdate']
);

?>