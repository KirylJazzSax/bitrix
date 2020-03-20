<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:25
 */

namespace Local\Classes\Collections\News;

use Bitrix\Main\Type\DateTime;

class News
{
    public $id;
    public $name;
    public $date;

    public function __construct(int $id, string $name, DateTime $activeFrom)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $activeFrom->format('Y-m-d');
    }
}