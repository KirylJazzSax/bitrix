<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.04.2020
 * Time: 16:49
 */

namespace Local\Classes\Collections\News;


class Complaint
{
    public $name;
    public $user;
    public $news;

    public function __construct(string $name, string $user, string $news)
    {
        $this->name = $name;
        $this->user = $user;
        $this->news = $news;
    }
}