<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.03.2020
 * Time: 19:01
 */

namespace Local\Classes\Collections\Manufacturing;


class ManufacturingCollection
{
    private $manufacturingCollection = [];

    public function add(Manufacturing $manufacturing): void
    {
        $this->manufacturingCollection[$manufacturing->id] = $manufacturing;
    }

    public function getAllManufacturing()
    {
        return $this->manufacturingCollection;
    }

    public function countManufacturing()
    {
        return count($this->manufacturingCollection);
    }
}