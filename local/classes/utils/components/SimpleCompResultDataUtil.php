<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use Bitrix\Main\SystemException;
use Local\Classes\Collections\User\UsersCollection;
use Local\Classes\Repositories\UserRepository;

class SimpleCompResultDataUtil
{
    private $usersCollection;
    private $userRepository;

    public function __construct(UsersCollection $usersCollection, UserRepository $userRepository)
    {
        $this->usersCollection = $usersCollection;
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     * @throws SystemException
     */
    public function prepare(): array
    {
        $this->guardData();

        $this->usersCollection->remove(
            $this->userRepository->getId()
        );

        return $this->usersCollection->getUsers();
    }

    private function guardData()
    {
        if (!$this->userRepository->isAuthorizedUser()) {
            throw new SystemException('Not authorized');
        }
    }
}