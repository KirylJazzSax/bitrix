<?php

namespace Local\Classes\Utils\App;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\UserTable;

class UserUtils
{
    const CONTENT_EDITOR_GROUP = 5;

    public function shouldBuildMenu()
    {
        return !$this->getUser()->IsAdmin() && $this->isContentEditor();
    }

    public function isContentEditor()
    {
        return in_array(self::CONTENT_EDITOR_GROUP, $this->getUser()->GetUserGroupArray());
    }

    private function getUser()
    {
        global $USER;
        return $USER;
    }
}