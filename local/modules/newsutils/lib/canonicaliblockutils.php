<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2020
 * Time: 11:43
 */

namespace Local\NewsUtils;

use CIBlockElement;

class CanonicalIBlockUtils
{
    const IBLOCK_ID = 5;
    const IBLOCK_CANONICAL_PARAMETER = 'ID_IBLOCK_CANONICAL';
    const CANONICAL_PROPERTY = 'canonical';

    private $iBlockCanonical;
    private $arParams;
    private $arResult;

    public function __construct(array $arParams, array $arResult)
    {
        $this->iBlockCanonical = CIBlockElement::GetList([], ['IBLOCK_ID' => self::IBLOCK_ID]);
        $this->arParams = $arParams;
        $this->arResult = $arResult;
    }

    public function isInParametersIdCanonical(): bool
    {
        return (int)$this->arParams[self::IBLOCK_CANONICAL_PARAMETER] === self::IBLOCK_ID;
    }

    /**
     * @param int $newsId
     * @return bool|string Имя элемента инфоблока Canonical
     */
    public function getNameCanonicalElement()
    {
        while ($ob = $this->iBlockCanonical->GetNextElement()) {
            if ((int)$ob->GetProperties()['news']['VALUE'] === (int)$this->arResult['ID']) {
                return $ob->GetFields()['NAME'];
            }
        }
        return false;
    }
}