<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2020
 * Time: 17:16
 */

namespace Local\Classes\Utils\Catalog;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Web\Uri;

class MetaTagsIblockUtils
{
    const IBLOCK_ID = 6;

    private $elements;
    private $uri;
    private $table;

    public function __construct(Uri $uri)
    {
        \Bitrix\Main\Loader::includeModule('iblock');

        $this->elements = ElementTable::getList(['filter' => ['IBLOCK_ID' => self::IBLOCK_ID]]);
        $this->uri = $uri;
        $this->table = $table;
    }

    public function canSetMetaTags(string $propertyName): bool
    {
        return $this->uri->getPath() === $this->preparePropertyName($propertyName);
    }

    public function getElements(): \Bitrix\Main\ORM\Query\Result
    {
        return $this->elements;
    }

    private function preparePropertyName(string $propertyName): string
    {
        return trim($propertyName);
    }
}