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
        => '/local/classes/eventhandlers/main/MainEventHandler.php',

        'Local\\Classes\\Loggers\\MainEventLogger'
        => '/local/classes/loggers/MainEventLogger.php',

        'Local\\Classes\\Utils\\App\\UserUtils'
        => '/local/classes/utils/app/UserUtils.php',

        'Local\\Classes\\Utils\\Menu\\AdminMenuBuilder'
        => '/local/classes/utils/menu/AdminMenuBuilder.php',

        'Local\\Classes\\Utils\\Catalog\\MetaTagsIblockUtils'
        => '/local/classes/utils/catalog/MetaTagsIblockUtils.php',

        'Local\\Classes\\EventHandlers\\Main\\PageEventHandler'
        => '/local/classes/eventhandlers/main/PageEventHandler.php',

        'Local\\Classes\\Utils\\App\\CIblockElementUtils'
        => '/local/classes/utils/app/CIblockElementUtils.php',

        'Local\\Classes\\Utils\\App\\ApplicationUtils'
        => '/local/classes/utils/app/ApplicationUtils.php'

    ]
);

?>