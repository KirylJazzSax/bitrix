<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.03.2020
 * Time: 16:48
 */

namespace Local\Classes\Loggers;

use CEventLog;

class MainEventLogger
{
    public static function log(string $type, string $description): void
    {
        CEventLog::Add(array(
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => $type,
                'MODULE_ID' => 'main',
                'DESCRIPTION' => $description,
            )
        );
    }
}