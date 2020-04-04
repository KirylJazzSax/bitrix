<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.04.2020
 * Time: 16:46
 */

namespace Local\Classes\Utils\News;


use Local\Classes\Collections\News\Complaint;

class ComplaintUtils
{
    public static function prepareFields(Complaint $complaint): array
    {
        return [
            'NAME' => $complaint->name,
            'PROPERTY_VALUES' => [
                'USER' => $complaint->user,
                'NEWS' => $complaint->news
            ]
        ];
    }
}