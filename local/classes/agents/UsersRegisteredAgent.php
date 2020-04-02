<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2020
 * Time: 21:16
 */

namespace Local\Classes\Agents;


use CEvent;
use COption;
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
    const EMAIL_EVENT_NAME = 'REGISTERED_USERS_COUNT';
    const ACTIVE = 'Y';
    const OPTION_NAME = 'last_exec_agent';

    public function CheckUserCount()
    {
        $agent = AgentRepository::getAgentByName(self::AGENT_NAME);
        $dateFrom = $this->getDateFrom($agent['AGENT_INTERVAL']);

        $fields = [
            'EMAIL_TO' => $this->getUsersEmailsString(),
            'COUNT' => $this->countUsers($dateFrom),
            'DAYS' => $this->getDaysDiff($dateFrom)
        ];

        $this->sendEmails($fields);

        $this->setOptionToModule($agent);

        return 'CheckUserCount();';
    }

    public static function getTimeStartAgent(): string
    {
        return (new DateTime())
            ->modify('+1 day')
            ->setTime(1, 0)
            ->format(self::DATE_FORMAT);
    }

    private function sendEmails(array $fields): bool
    {
        return CEvent::Send(
            self::EMAIL_EVENT_NAME,
            SITE_ID,
            $fields,
            'N',
            self::EMAIL_TEMPLATE_ID
        );
    }

    private function setOptionToModule(array $agent): void
    {
        COption::SetOptionString('main', self::OPTION_NAME, $agent['LAST_EXEC']);
    }

    private function countUsers(string $dateFrom): int
    {
        return count(UserRepository::getLastRegisteredUsers($dateFrom));
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