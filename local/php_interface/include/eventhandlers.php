<?

use Bitrix\Main\EventManager;
use Local\Classes\EventHandlers\Catalog\ProductEventHandler;
use Local\Classes\EventHandlers\Main\MainEventHandler;

$eventManager = EventManager::getInstance();

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

?>