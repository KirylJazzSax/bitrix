<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2020
 * Time: 13:47
 */

namespace Local\Classes\Collections\User;


use Local\Classes\Collections\Interfaces\CollectionInterface;

class UsersCollection implements CollectionInterface
{
    private $users = [];

    public function add(User $user)
    {
        $this->users[$user->id] = $user;
    }

    public function getUser(int $id): User
    {
        return $this->users[$id];
    }

    public function getAll(): array
    {
        return $this->users;
    }

    public function remove(int $id): void
    {
        unset($this->users[$id]);
    }

    public function notExists(int $id): bool
    {
        return !array_key_exists($id, $this->users);
    }
}