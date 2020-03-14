<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.2020
 * Time: 19:01
 */

namespace Local\Classes\EventHandlers\Main;

use Bitrix\Main\Application;
use CEventLog;

class MainEventHandler
{
    public function handle404()
    {
        $server = Application::getInstance()->getContext()->getServer();

        if (ERROR_404 === "Y") {
            CEventLog::Add(array(
                    'SEVERITY' => 'INFO',
                    'AUDIT_TYPE_ID' => 'ERROR_404',
                    'MODULE_ID' => 'main',
                    'DESCRIPTION' => $server->getRequestUri(),
                )
            );
        }
        return true;
    }
}