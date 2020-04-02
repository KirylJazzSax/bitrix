<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2020
 * Time: 18:14
 */

namespace Local\Classes\Repositories;


use CAgent;

class AgentRepository
{
    public static function getAgentByName(string $name): array
    {
        return CAgent::GetList(false, ['NAME' => $name])->GetNext();
    }
}