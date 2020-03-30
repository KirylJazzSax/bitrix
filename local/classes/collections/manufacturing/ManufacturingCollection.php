<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.03.2020
 * Time: 19:01
 */

namespace Local\Classes\Collections\Manufacturing;


use Local\Classes\Collections\Interfaces\CollectionInterface;

class ManufacturingCollection implements CollectionInterface
{
    private $manufacturingCollection = [];

    public function add(Manufacturing $manufacturing): void
    {
        $this->manufacturingCollection[$manufacturing->id] = $manufacturing;
    }

    public function getAll(): array
    {
        return $this->manufacturingCollection;
    }

    public function countManufacturing()
    {
        return count($this->manufacturingCollection);
    }

    public function getManufacturing(int $id): Manufacturing
    {
        return $this->manufacturingCollection[$id];
    }

    public function exists($id): bool
    {
        return array_key_exists($id, $this->manufacturingCollection);
    }
}