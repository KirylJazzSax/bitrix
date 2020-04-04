<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 17:56
 */

namespace Local\Classes\Utils\App;

use CMain;

class ApplicationUtils
{
    private $application;

    public function __construct(CMain $application)
    {
        $this->application = $application;
    }

    public function setMetaTags(string $keywords, string $description): void
    {
        $this->application->SetPageProperty('keywords', $keywords);
        $this->application->SetPageProperty('description', $description);
    }

    public function setTitle(string $title): void
    {
        $this->application->SetTitle($title);
    }

    public function getApp(): CMain
    {
        return $this->application;
    }

    public function complaintUrlRedirect($idComplaint): string
    {
        $params = $idComplaint ? "COMPLAINT_ID=$idComplaint&COMPLAINT_SUCCESS=Y" : "COMPLAINT_SUCCESS=N";
        return $this->application->GetCurPageParam($params, ['COMPLAINT']);
    }
}