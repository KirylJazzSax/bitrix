<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 17:56
 */

namespace Local\Classes\Utils\App;

class ApplicationUtils
{
    private $application;

    public function __construct(\CMain $application)
    {
        $this->application = $application;
    }

    public function setMetaTags(string $keywords, string $description): void
    {
        $this->application->SetPageProperty('keywords', $keywords);
        $this->application->SetPageProperty('description', $description);
    }
}