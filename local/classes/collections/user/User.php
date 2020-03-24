<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2020
 * Time: 13:46
 */

namespace Local\Classes\Collections\User;

use Local\Classes\Collections\News\NewsCollection;

class User
{
    public $id;
    public $login;
    public $news;

    public function __construct(int $id, string $login, NewsCollection $news)
    {
        $this->id = $id;
        $this->login = $login;
        $this->news = $news;
    }
}