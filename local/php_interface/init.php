<?php

use test\CApp;
use test\CCity;
use test\CEvents;
use test\CIBlockUtils;

CModule::AddAutoloadClasses(
    '',
    [
        CApp::class => '/local/classes/test/CApp.php',
        CCity::class => '/local/classes/test/CCity.php',
        CEvents::class => '/local/classes/test/CEvents.php',
        CIBlockUtils::class => '/local/classes/test/CIBlockUtils.php',
    ]
);

