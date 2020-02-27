<?php

namespace test;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class CIBlockUtils
{
    /**
     * @param string $code
     * @return int
     * @throws LoaderException
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getIBlockID($code = null): int
    {
        if (!$code) {
            return 0;
        }

        if (Loader::includeModule('iblock')) {
            return IblockTable::GetList([
                'order' => [],
                'filter' => ['CODE' => $code],
                'select' => ['ID'],
            ])->fetchRaw()['ID'];
        }

    }
}