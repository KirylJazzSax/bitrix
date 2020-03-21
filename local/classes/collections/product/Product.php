<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:15
 */

namespace Local\Classes\Collections\Product;


class Product
{
    public $id;
    public $name;
    public $props;

    public function __construct(int $id, string $name, ProductProperties $props)
    {
        $this->id = $id;
        $this->name = $name;
        $this->props = $props;
    }
}