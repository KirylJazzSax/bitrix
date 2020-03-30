<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2020
 * Time: 13:46
 */

namespace Local\Classes\Collections\User;

use Local\Classes\Collections\Interfaces\CollectionInterface;

class User
{
    public $id;
    public $login;
    public $news;

    public function __construct(int $id, string $login, CollectionInterface $news)
    {
        $this->id = $id;
        $this->login = $login;
        $this->news = $news;
    }
}