<?php

namespace test;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Iblock;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use CIBlockElement;

class CEvents
{
    private $iBlockCode = 'EVENTS';
    private $iBlockId;
    private $filter;

    public $events = [];

    /**
     * CCity constructor.
     * @param array $filter
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */

    public function __construct($filter = array())
    {
        $this->iBlockId = CIBlockUtils::getIBlockID($this->iBlockCode);

        if (count($filter)) {
            $this->filter = $filter;
        }
    }

    private function convertDate($date = '')
    {

    }

    /**
     * @param int $elementId
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */

    private function getUsers(int $elementId): array
    {
        $users = [];
        $res = CIBlockElement::GetProperty(
            $this->iBlockId,
            $elementId,
            ['NAME' => 'ASC'],
            ['CODE' => 'USERS']
        );

        while ($arProp = $res->Fetch()) {
            $users[(int)$arProp['VALUE']] = (int)$arProp['VALUE'];
        }

        $resNames = ElementTable::getList([
            'filter' => ['=ID' => array_values($users)],
            'select' => ['ID', 'NAME']
        ]);

        while ($arNames = $resNames->fetch()) {
            $users[$arNames['ID']] = $arNames['NAME'];
        }

        return $users;
    }

    /**
     * @return CEvents
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     * У меня не получилось получить множественное свойство участников
     */

    public function getEvents(): CEvents
    {
        if (Loader::includeModule('iblock')) {
            $iBlock = Iblock::wakeUp($this->iBlockId);
            $arFilter = [];
            if (isset($this->filter['DATE'])) {
                $arFilter['>EVENT_DATE.VALUE'] = date('Y-m-d H:i:s ',MakeTimeStamp($this->filter['DATE']));
            }

            $elements = $iBlock->getEntityDataClass()::getList([
                'order' => ['EVENT_DATE.VALUE' => 'ASC'],
                'filter' => $arFilter,
                'select' => [
                    'ID',
                    'NAME',
                    'CITY.VALUE',
                    'EVENT_DATE.VALUE',
//                    'USERS.VALUE'
                ]
            ])->fetchCollection();

            foreach ($elements as $element) {
                $cityID = $element->getCity()->getValue();
                $this->events[$cityID][] = [
                    'ID' => $element->getId(),
                    'NAME' => $element->getName(),
                    'EVENT_DATE' => $element->getEventDate()->getValue(),
//                    'USERS' => $element->getUsers()
                    'USERS' => $this->getUsers($element->getId())
                ];
            }
        }

        return $this;
    }
}