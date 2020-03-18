<?php

namespace Local\Classes\Utils\App;

class UserUtils
{
    const CONTENT_EDITOR_GROUP = 5;

    private $user;

    public function __construct(\CUser $user)
    {
        $this->user = $user;
    }

    public function shouldBuildMenu()
    {
        return !$this->user->IsAdmin() && $this->isContentEditor();
    }

    public function isContentEditor()
    {
        return in_array(self::CONTENT_EDITOR_GROUP, $this->user->GetUserGroupArray());
    }

    public function makeMessageAuthorMacros($author)
    {
        if ($this->user->IsAuthorized()) {
            $id = $this->user->GetID();
            $login = $this->user->GetLogin();
            $name = $this->user->GetFirstName();
            return "Пользователь авторизован: $id, ($login) $name, данные из формы: $author.";
        }
        return "Пользователь не авторизован, данные из формы: $author.";
    }
}