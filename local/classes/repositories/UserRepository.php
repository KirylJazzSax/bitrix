<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2020
 * Time: 13:53
 */

namespace Local\Classes\Repositories;

use Bitrix\Main\UserTable;
use CUser;

class UserRepository
{
    private $user;

    public function __construct(CUser $user)
    {
        $this->user = $user;
    }

    public function getId()
    {
        return $this->user->GetID();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getGroupsString(): string
    {
        return $this->user->GetGroups();
    }

    public function isAuthorizedUser(): bool
    {
        return $this->user->IsAuthorized();
    }

    public function getUserField(string $code)
    {
        return UserTable::getByPrimary($this->getId(), ['select' => [$code]])->fetch()[$code];
    }
}