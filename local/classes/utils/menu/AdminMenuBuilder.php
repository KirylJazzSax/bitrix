<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 11:35
 */

namespace Local\Classes\Utils\Menu;


class AdminMenuBuilder
{
    const CONTENT_MENU_KEY = 'global_menu_content';

    private $aGlobalMenu;
    private $aModuleMenu;

    public function __construct(array $aGlobalMenu, array $aModuleMenu)
    {
        $this->aGlobalMenu = $aGlobalMenu;
        $this->aModuleMenu = $aModuleMenu;
    }

    public function leaveOnlyContent()
    {
        return array_filter($this->aGlobalMenu, [$this, 'callbackOnlyContent'], ARRAY_FILTER_USE_KEY);
    }

    public function leaveOnlyNews()
    {
        return array_filter($this->aModuleMenu, [$this, 'callbackOnlyNews']);
    }

    private function callbackOnlyContent($key)
    {
        return $key === self::CONTENT_MENU_KEY;
    }

    private function callbackOnlyNews($value)
    {
        return $value['parent_menu'] === self::CONTENT_MENU_KEY && parse_url($value['url'])['path'] === 'iblock_admin.php';
    }
}