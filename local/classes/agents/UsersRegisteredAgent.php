<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2020
 * Time: 21:16
 */

namespace Local\Classes\Agents;


use CEvent;
use DateTime;
use Local\Classes\Repositories\AgentRepository;
use Local\Classes\Repositories\UserRepository;

class UsersRegisteredAgent
{
    const IS_PERIOD = 'Y';
    const INTERVAL = 86400;
    const DATE_FORMAT = 'd.m.Y H:i:s';
    const AGENT_NAME = 'UsersRegisteredAgent::CheckUserCount();';
    const EMAIL_TEMPLATE_ID = 31;
    const ACTIVE = 'Y';

    public function CheckUserCount()
    {
        $dateFrom = $this->getDateFrom($this->getAgentInterval());

        $fields = [
            'EMAIL_TO' => $this->getUsersEmailsString(),
            'COUNT' => $this->countUsers($dateFrom),
            'DAYS' => $this->getDaysDiff($dateFrom)
        ];

        CEvent::Send(
            'REGISTERED_USERS_COUNT',
            SITE_ID,
            $fields,
            'N',
            self::EMAIL_TEMPLATE_ID
        );

        return 'CheckUserCount();';
    }

    public static function getTimeStartAgent(): string
    {
        return (new DateTime())
            ->modify('+1 day')
            ->setTime(1, 0)
            ->format(self::DATE_FORMAT);
    }

    private function countUsers(string $dateFrom): int
    {
        return count(UserRepository::getLastRegisteredUsers($dateFrom));
    }

    private function getAgentInterval(): int
    {
        return AgentRepository::getAgentByName(self::AGENT_NAME)['AGENT_INTERVAL'];
    }

    private function getUsersEmailsString(): string
    {
        return implode(', ', UserRepository::getEmailsUserGroup(UserRepository::ADMINS_USER_GROUP));
    }

    private function getDateFrom(int $intervalSeconds): string
    {
        return (new DateTime())
            ->modify('-' . $intervalSeconds . ' seconds')
            ->format(self::DATE_FORMAT);
    }

    private function getDaysDiff(string $from): int
    {
        return (new DateTime(strtotime($from)))->diff(new DateTime())->d;
    }
}