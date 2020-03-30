<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:11
 */

namespace Local\Classes\Collections\Section;

use Local\Classes\Collections\Interfaces\CollectionInterface;

class Section
{
    public $id;
    public $name;
    public $products;


    public function __construct(int $id, string $name, CollectionInterface $productsCollection)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = $productsCollection;
    }
}