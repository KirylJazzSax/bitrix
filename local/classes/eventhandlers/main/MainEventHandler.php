<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.2020
 * Time: 19:01
 */

namespace Local\Classes\EventHandlers\Main;

use Bitrix\Main\Application;
use Local\Classes\Loggers\MainEventLogger;
use Local\Classes\Utils\App\UserUtils;
use Local\Classes\Utils\Menu\AdminMenuBuilder;

class MainEventHandler
{
    public function handle404()
    {
        $server = Application::getInstance()->getContext()->getServer();

        if (ERROR_404 === "Y") {
            MainEventLogger::log('ERROR_404', $server->getRequestUri());
        }
        return true;
    }

    public function handleFeedbackForm(&$arFields)
    {
        global $USER;
        $userUtils = new UserUtils($USER);

        $author = $arFields['AUTHOR'];
        $arFields['AUTHOR'] = $userUtils->makeMessageAuthorMacros($author);

        $logDescription = 'Замена данных в отсылаемом письме – ' . $arFields['AUTHOR'];

        MainEventLogger::log('CHANGE_MACROS_AUTHOR', $logDescription);

        return true;
    }

    public function handleBuildMenuForContentEditors(&$aGlobalMenu, &$aModuleMenu)
    {
        global $USER;
        $userUtils = new UserUtils($USER);

        if ($userUtils->shouldBuildMenu()) {
            $menuBuilder = new AdminMenuBuilder($aGlobalMenu, $aModuleMenu);

            $aGlobalMenu = $menuBuilder->leaveOnlyContent();
            $aModuleMenu = $menuBuilder->leaveOnlyNews();
        }
    }
}