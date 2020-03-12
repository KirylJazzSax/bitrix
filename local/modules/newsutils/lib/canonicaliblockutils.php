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
    private $iBlockCanonical;

    public function __construct()
    {
        $this->iBlockCanonical = CIBlockElement::GetList([], ['IBLOCK_ID' => 5]);
    }

    /**
     * @param int $newsId
     * @return bool|string Имя элемента инфоблока Canonical
     */
    public function getNameCanonicalElement(int $newsId)
    {
        while ($ob = $this->iBlockCanonical->GetNextElement()) {
            if ((int)$ob->GetProperties()['news']['VALUE'] === $newsId) {
                return trim($ob->GetFields()['NAME']);
            }
        }
        return false;
    }
}