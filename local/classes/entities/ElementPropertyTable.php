<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2020
 * Time: 13:56
 */

namespace Local\Classes\Entities;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\Validator\Length;

/**
 * Class ElementPropertyTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> IBLOCK_PROPERTY_ID int mandatory
 * <li> IBLOCK_ELEMENT_ID int mandatory
 * <li> VALUE string mandatory
 * <li> VALUE_TYPE enum ('text', 'html') optional default 'text'
 * <li> VALUE_ENUM int optional
 * <li> VALUE_NUM double optional
 * <li> DESCRIPTION string(255) optional
 * <li> IBLOCK_ELEMENT reference to {@link \Bitrix\Iblock\IblockElementTable}
 * <li> IBLOCK_PROPERTY reference to {@link \Bitrix\Iblock\IblockPropertyTable}
 * </ul>
 *
 * @package Bitrix\Iblock
 **/
class ElementPropertyTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
{
    return 'b_iblock_element_property';
}

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
{
    return array(
        'ID' => array(
            'data_type' => 'integer',
            'primary' => true,
            'autocomplete' => true,
            'title' => 'id prop',
        ),
        'IBLOCK_PROPERTY_ID' => array(
            'data_type' => 'integer',
            'required' => true,
            'title' => 'iblock id',
        ),
        'IBLOCK_ELEMENT_ID' => array(
            'data_type' => 'integer',
            'required' => true,
            'title' => 'iblock element id',
        ),
        'VALUE' => array(
            'data_type' => 'text',
            'required' => true,
            'title' => 'value',
        ),
        'VALUE_TYPE' => array(
            'data_type' => 'enum',
            'values' => array('text', 'html'),
            'title' => 'type of value',
        ),
        'VALUE_ENUM' => array(
            'data_type' => 'integer',
            'title' => 'enum field',
        ),
        'VALUE_NUM' => array(
            'data_type' => 'float',
            'title' => 'mun value',
        ),
        'DESCRIPTION' => array(
            'data_type' => 'string',
            'validation' => array(__CLASS__, 'validateDescription'),
            'title' => 'description',
        ),
        'IBLOCK_ELEMENT' => array(
            'data_type' => 'Bitrix\Iblock\IblockElement',
            'reference' => array('=this.IBLOCK_ELEMENT_ID' => 'ref.ID'),
        ),
        'IBLOCK_PROPERTY' => array(
            'data_type' => 'Bitrix\Iblock\IblockProperty',
            'reference' => array('=this.IBLOCK_PROPERTY_ID' => 'ref.ID'),
        ),
    );
}

    /**
     * Returns validators for DESCRIPTION field.
     *
     * @return array
     */
    public static function validateDescription()
{
    return array(
        new Length(null, 255),
    );
}

    public static function getMultipleProps(int $iblockId, int $elementId)
{
    return self::getList(['filter' => ['IBLOCK_ELEMENT_ID' => 2]])->fetchAll();
}
}