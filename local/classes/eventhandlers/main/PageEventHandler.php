<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 17:17
 */

namespace Local\Classes\EventHandlers\Main;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Context;
use Bitrix\Main\Web\Uri;
use Local\Classes\Utils\App\ApplicationUtils;
use Local\Classes\Utils\App\CIblockElementUtils;
use Local\Classes\Utils\Catalog\MetaTagsIblockUtils;

class PageEventHandler
{
    public function handlePageStartMetaTags()
    {
        global $APPLICATION;
        $request = Context::getCurrent()->getRequest();
        $uri = new Uri($request->getRequestUri());

        $metaTagsHelper = new MetaTagsIblockUtils($uri);
        $applicationUtils = new ApplicationUtils($APPLICATION);

        while ($element = $metaTagsHelper->getElements()->fetch()) {
            if ($metaTagsHelper->canSetMetaTags($element['NAME'])) {

                $title = CIblockElementUtils::getProperty($element['ID'], 'title');
                $desc = CIblockElementUtils::getProperty($element['ID'], 'description');

                $applicationUtils->setMetaTags($title, $desc);
            }
        }
    }
}