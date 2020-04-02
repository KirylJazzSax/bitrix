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
    const ADMINS_USER_GROUP = 1;

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

    public static function getEmailsUserGroup($groupId, $order = 'asc', $by = 'id'): array
    {
        $emails = [];

        $users = CUser::GetList($by, $order, ['GROUPS_ID' => $groupId]);
        while ($user = $users->GetNext()) {
            $emails[] = $user['EMAIL'];
        }

        return $emails;
    }

    public static function getLastRegisteredUsers(string $dateFrom, $by = 'id', $order = 'asc'): array
    {
        $result = [];

        $format = 'd.m.Y H:i:s';
        $filter = [
            'DATE_REGISTER_1' => date($format, strtotime($dateFrom)),
            'DATE_REGISTER_2' => date($format)
        ];

        $users = CUser::GetList($by, $order, $filter);
        while ($user = $users->GetNext()) {
            $result[] = $user;
        }

        return $result;
    }
}