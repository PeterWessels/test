<?php

namespace test;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class CCity
{
    private $iBlockCode = 'CITY';
    private $iBlockId;
    private $city = [];

    /**
     * CCity constructor.
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */

    public function __construct()
    {
        $this->iBlockId = CIBlockUtils::getIBlockID($this->iBlockCode);
    }

    /**
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */

    public function getCity()
    {
        if (Loader::includeModule('iblock')) {
            $res = ElementTable::getlist([
                'order' => ['NAME' => 'ASC'],
                'filter' => ['IBLOCK_ID' => $this->iBlockId],
                'select' => ['ID', 'NAME']
            ]);

            while ($arCity = $res->fetch()) {
                $this->city[$arCity['ID']] = $arCity;
            }
        }

        return $this->city;
    }
}