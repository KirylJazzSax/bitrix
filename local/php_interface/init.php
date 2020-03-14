<?

use Bitrix\Main\Application;

require_once Application::getDocumentRoot() . '/local/php_interface/include/eventhandlers.php';

CModule::AddAutoloadClasses(
    '',
    [
        'Local\\Classes\\Utils\\News\\NewsUtils'
        => '/local/classes/utils/news/NewsUtils.php',

        'Local\\Classes\\Utils\\News\\CanonicalIBlockUtils'
        => '/local/classes/utils/news/CanonicalIBlockUtils.php',

        'Local\\Classes\\Utils\\Catalog\\ProductHelper'
        => '/local/classes/utils/catalog/ProductHelper.php',

        'Local\\Classes\\EventHandlers\\Catalog\\ProductEventHandler'
        => '/local/classes/eventhandlers/catalog/ProductEventHandler.php',

        'Local\\Classes\\EventHandlers\\Main\\MainEventHandler'
        => '/local/classes/eventhandlers/main/MainEventHandler.php'
    ]
);

?>