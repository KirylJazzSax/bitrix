<?php

namespace Local\Classes\Collections\Section;

class SectionsCollection
{
    private $sections = [];

    public function addSection(Section $section)
    {
        $this->sections[$section->id] = $section;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function getSection(int $id): Section
    {
        return $this->sections[$id];
    }
}