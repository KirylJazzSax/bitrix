<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.2020
 * Time: 19:01
 */

namespace Local\Classes\EventHandlers\Main;

use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
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
        $author = $arFields['AUTHOR'];
        $arFields['AUTHOR'] = self::makeAuthorMessage($author);

        $logDescription = 'Замена данных в отсылаемом письме – ' . $arFields['AUTHOR'];

        MainEventLogger::log('CHANGE_MACROS_AUTHOR', $logDescription);

        return true;
    }

    public function handleBuildMenuForContentEditors(&$aGlobalMenu, &$aModuleMenu) {

        $userUtils = new UserUtils();

        if ($userUtils->shouldBuildMenu()) {
            $menuBuilder = new AdminMenuBuilder($aGlobalMenu, $aModuleMenu);

            $aGlobalMenu = $menuBuilder->leaveOnlyContent();
            $aModuleMenu = $menuBuilder->leaveOnlyNews();
        }
    }

    private function makeAuthorMessage($author)
    {
        global $USER;
        if ($USER->IsAuthorized()) {
            $id = $USER->GetID();
            $login = $USER->GetLogin();
            $name = $USER->GetFirstName();
            return "Пользователь авторизован: $id, ($login) $name, данные из формы: $author.";
        }
        return "Пользователь не авторизован, данные из формы: $author.";
    }
}