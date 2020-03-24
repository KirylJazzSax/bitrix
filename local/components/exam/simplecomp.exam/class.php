<?php

use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\SystemException;
use Local\Classes\Collections\News\News;
use Local\Classes\Collections\News\NewsCollection;
use Local\Classes\Collections\User\User;
use Local\Classes\Collections\User\UsersCollection;
use Local\Classes\Entities\ElementPropertyTable;
use Local\Classes\Repositories\NewsRepository;
use Local\Classes\Repositories\UserRepository;
use Local\Classes\Utils\Components\SimpleCompResultDataUtil;

\Bitrix\Main\Loader::includeModule('iblock');


class SimpleComponentExam extends CBitrixComponent
{
    const DATA_KEY = 'DATA';
    const NEWS_COUNT_KEY = 'NEWS_COUNT';

    private $userRepository;
    private $newsRepository;

    public function __construct(?CBitrixComponent $component = null)
    {
        global $USER;
        $this->userRepository = new UserRepository($USER);
        $this->newsRepository = new NewsRepository();

        parent::__construct($component);
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $manufacturingCollection = $this->prepareManufacturingCollection();
        $productsCollection = $this->prepareProductsCollection();

        $data = (new SimpleCompResultDataUtil($manufacturingCollection, $productsCollection))->prepareDataArResult();

        $this->setCacheByGroup($data);

        $this->arResult['DATA'] = $data;
        $this->arResult['MANUFACTURING_COUNT'] = $manufacturingCollection->countManufacturing();

        global $APPLICATION;
        $APPLICATION->SetTitle('Новостей: ' . $this->arResult[self::NEWS_COUNT_KEY]);
    }

    private function makeUsersCollection(array $elements): UsersCollection
    {
        $usersCollection = new UsersCollection();

        foreach ($elements as $element) {
            if ($usersCollection->notExists($element['USER_ID'])) {

                $newsCollection = $this->prepareNewsCollection($element);
                $usersCollection->add(
                    new User($element['USER_ID'], $element['USER_LOGIN'], $newsCollection)
                );
            } else {
                $usersCollection->getUser($element['USER_ID'])->news->add(
                    new News($element['ID'], $element['NAME'], $element['ACTIVE_FROM'])
                );
            }

        }

        return $usersCollection;
    }

    private function prepareNewsCollection(array $element): NewsCollection
    {
        $newsCollection = new NewsCollection();

        $newsCollection->add(
            new News(
                $element['ID'], $element['NAME'], $element['ACTIVE_FROM']
            )
        );

        return $newsCollection;
    }

    private function getNewsByAuthorGroups()
    {
        $select = [
            'ID',
            'NAME',
            'ACTIVE_FROM',
            'USER_ID' => 'USER.ID',
            'USER_LOGIN' => 'USER.LOGIN',
            'AUTHOR_GROUP' => 'USER.UF_AUTHOR_TYPE',
            'AUTHOR_ID' => 'PROPERTY.VALUE',
            'PROP_ID' => 'PROPERTY.ID',
            'PROP_CODE' => 'PROP.CODE',
        ];

        $filter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_NEWS_ID'],
            '=AUTHOR_GROUP' => $this->userRepository->getUserField($this->arParams['CODE_USER_FIELD_AUTHOR']),
            '!=AUTHOR_ID' => null,
            '=PROP_CODE' => $this->arParams['CODE_NEWS_PROP_AUTHOR']
        ];

        $runtime = [
            new ReferenceField(
                'PROPERTY',
                ElementPropertyTable::class,
                \Bitrix\Main\ORM\Query\Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            ),
            new ReferenceField(
                'PROP',
                '\Bitrix\Iblock\PropertyTable',
                array(
                    '=this.PROPERTY.IBLOCK_PROPERTY_ID' => 'ref.ID'
                ),
                array('join_type' => 'LEFT')
            ),
            new Reference(
                'USER',
                \Bitrix\Main\UserTable::class,
                array('=this.PROPERTY.VALUE' => 'ref.ID')
            )
        ];

        return NewsRepository::getNews($select, $filter, $runtime);
    }

    private function setCacheIncludeTemplate($data)
    {
        if ($this->startResultCache(false, $this->userRepository->getId())) {
            $this->arResult[self::DATA_KEY] = $data;
            $this->arResult[self::NEWS_COUNT_KEY] = $this->countNews($data);

            $this->includeComponentTemplate();
        }
    }

    private function setCacheByGroup($data)
    {
        global $USER;
        if ($this->startResultCache(false, $USER->GetGroups())) {
            // делаем что-нибудь с $data
        }
        return count($newsIds);
    }
}


