<?

use Bitrix\Main\EventManager;
use Local\Classes\EventHandlers\Catalog\ProductEventHandler;
use Local\Classes\EventHandlers\Catalog\ServicesEventHandler;
use Local\Classes\EventHandlers\Main\MainEventHandler;
use Local\Classes\EventHandlers\Main\PageEventHandler;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    [ServicesEventHandler::class, 'clearCacheOnElementUpdate']
);

$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    [ProductEventHandler::class, 'onBeforeUpdate']
);

$eventManager->addEventHandler(
    'main',
    'OnEpilog',
    [MainEventHandler::class, 'handle404']
);

$eventManager->addEventHandler(
    'main',
    'OnBeforeEventSend',
    [MainEventHandler::class, 'handleFeedbackForm']
);

$eventManager->addEventHandler(
    'main',
    'OnBuildGlobalMenu',
    [MainEventHandler::class, 'handleBuildMenuForContentEditors']
);

$eventManager->addEventHandler(
    'main',
    'OnPageStart',
    [PageEventHandler::class, 'handlePageStartMetaTags']
);

?>