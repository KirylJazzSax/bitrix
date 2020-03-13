<?php

namespace Local\NewsUtils;

class NewsUtils
{
    const FIRST_NEWS_KEY = 'FIRST_NEWS_DATE';
    const SPECIALDATE_PARAMETER = 'SHOW_SPECIALDATE_META';
    const SPECIALDATE_PROPERTY = 'specialdate';

    private $component;
    private $application;

    /**
     * @param \CBitrixComponent $component
     * @param \CMain $application
     */
    public function __construct(\CBitrixComponent $component, \CMain $application)
    {
        $this->component = $component;
        $this->application = $application;
    }

    public function canSetPageProperty(): bool
    {
        if (!$this->isCheckboxSpecialdateSet() || $this->isSpecialdateEqualsFirstNews()) {
            return false;
        }
        return true;
    }

    public function getFirstNewsDate()
    {
        return $this->component->arResult['ITEMS'][0]['ACTIVE_FROM'];
    }

    public function setCacheKeyFirstNews(): void
    {
        $this->component->setResultCacheKeys(self::FIRST_NEWS_KEY);
    }

    private function isCheckboxSpecialdateSet(): bool
    {
        return $this->component->getParent()->arParams[self::SPECIALDATE_PARAMETER] === "Y";
    }

    private function isSpecialdateEqualsFirstNews(): bool
    {
        return $this->application->GetProperty(self::SPECIALDATE_PROPERTY) === $this->getFirstNewsDate();
    }

}