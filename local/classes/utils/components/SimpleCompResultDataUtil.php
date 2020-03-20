<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.03.2020
 * Time: 10:33
 */

namespace Local\Classes\Utils\Components;

use Local\Classes\Collections\News\News;
use Local\Classes\Collections\News\NewsCollection;
use Local\Classes\Collections\Section\Section;
use Local\Classes\Collections\Section\SectionsCollection;

class SimpleCompResultDataUtil
{
    private $newsCollection;
    private $sectionsCollection;

    public function __construct(NewsCollection $newsCollection, SectionsCollection $sectionsCollection)
    {
        $this->newsCollection = $newsCollection;
        $this->sectionsCollection = $sectionsCollection;
    }

    public function prepareResultDataForComponent(): array
    {
        $result = [];
        foreach ($this->sectionsCollection->getSections() as $section) {
            $result = $this->prepareElementOfResultData($result, $section);
        }
        return $result;
    }

    private function prepareElementOfResultData(array $result, Section $section): array
    {
        foreach ($this->newsCollection->getAllNews() as $news) {
            $result = $this->setValues($result, $news, $section);
        }
        return $result;
    }

    private function setValues(array $result, News $news, Section $section)
    {
        if ($this->canPushNewsToArray($news, $section)) {
            $result = $this->setNews($result, $news);
            $result = $this->setSections($result, $news, $section);
        }

        return $result;
    }

    private function canPushNewsToArray(News $news, Section $section): bool
    {
        return in_array($news->id, $section->ufNewsLink);
    }

    private function setNews(array $result, News $news): array
    {
        if (!isset($result[$news->id]['news'])) {
            $result[$news->id]['news'] = $news;
        }
        return $result;
    }

    private function setSections(array $result, News $news, Section $section): array
    {
        $result[$news->id]['sections'][] = $section;
        return $result;
    }
}