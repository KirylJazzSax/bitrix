<?php

namespace Local\Classes\Collections\Section;

use Local\Classes\Collections\Interfaces\CollectionInterface;

class SectionsCollection implements CollectionInterface
{
    private $sections = [];

    public function addSection(Section $section)
    {
        $this->sections[$section->id] = $section;
    }

    public function getAll(): array
    {
        return $this->sections;
    }

    public function getSection(int $id): Section
    {
        return $this->sections[$id];
    }

    public function notExists(int $id): bool
    {
        return !array_key_exists($id, $this->sections);
    }
}