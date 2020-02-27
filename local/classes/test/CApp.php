<?php

namespace test;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Context;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

class CApp
{
    /**
     * Базовые переменные
     */
    private $request;
    public $city;
    public $events;

    /**
     * Инициализация объектов
     */
    private $CCity;
    private $CEvents;

    /**
     * CApp constructor.
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function __construct()
    {
        $this->request = Context::getCurrent()->getRequest()->toArray();

        $this->CCity = new CCity();
        $this->city = $this->CCity->getCity();

        $this->CEvents = new CEvents($this->request);
        $this->events = $this->CEvents->getEvents();
    }

    public function getFilterDate()
    {
        return $this->request['DATE'];
    }
}