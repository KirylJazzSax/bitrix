<?php

namespace Local\Classes\Utils\News;

class NewsUtils
{
    private $component;
    private $application;
    private $firstNewsDate;
    private $cacheAborted;

    /**
     * @param \CBitrixComponent $component
     * @param \CMain $application
     */
    public function __construct(\CBitrixComponent $component, \CMain $application)
    {
        $this->component = $component;
        $this->application = $application;
        $this->firstNewsDate = $this->component->arResult['ITEMS'][0]['ACTIVE_FROM'];
        $this->cacheAborted = false;
    }

    public function abortCacheIfSpecialParamSet(): bool
    {
        if (!$this->isCheckboxSpecialdateSet()) {
            return $this->cacheAborted;
        }

        if ($this->isSpecialdateEqualsFirstNews()) {
            return $this->cacheAborted;
        }

        $this->component->abortResultCache();
        $this->cacheAborted = true;
        return true;
    }

    public function setSpecialdateProperty(): void
    {
        if ($this->cacheAborted) {
            $this->application->SetPageProperty('specialdate', $this->firstNewsDate);
        }
    }

    private function isCheckboxSpecialdateSet(): bool
    {
        return $this->component->arParams['SHOW_SPECIALDATE_META'] === "Y";
    }

    private function isSpecialdateEqualsFirstNews(): bool
    {
        return $this->application->GetProperty('specialdate') === $this->firstNewsDate;
    }
}