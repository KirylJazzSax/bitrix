<?

use Local\Classes\Agents\UsersRegisteredAgent;

CAgent::AddAgent(
    UsersRegisteredAgent::AGENT_NAME,
    '',
    UsersRegisteredAgent::IS_PERIOD,
    UsersRegisteredAgent::INTERVAL,
    '',
    UsersRegisteredAgent::ACTIVE,
    UsersRegisteredAgent::getTimeStartAgent()
);
