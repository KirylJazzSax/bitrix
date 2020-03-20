<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:25
 */

namespace Local\Classes\Collections\News;


class NewsCollection
{
    private $news = [];

    public function add(News $news)
    {
        $this->news[$news->id] = $news;
    }

    public function getNews($id)
    {
        return $this->news[$id];
    }

    public function getAllNews()
    {
        return $this->news;
    }
}