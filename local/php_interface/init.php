<?php

include_once __DIR__ . '/classes/BXHelper.php';


if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php");
}
if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php");
}

if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php");
}

function pr($var, $type = false) {
    echo '<pre style="font-size:10px; border:1px solid #000; background:#FFF; text-align:left; color:#000;">';
    if ($type)
        var_dump($var);
    else
        print_r($var);
    echo '</pre>';
}

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

// пользовательский тип для свойства инфоблока
$eventManager->AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [
        'UserTypes\IBLink', // класс обработчик пользовательского типа свойства
        'GetUserTypeDescription'
    ]
);

$eventManager->AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    [
        'UserTypes\CUserTypeOnLineRecord', // класс обработчик пользовательского типа свойства
        'GetUserTypeDescription'
    ]
);


// пользовательский тип для UF поля
$eventManager->AddEventHandler(
    'main',
    'OnUserTypeBuildList',
    [
        'UserTypes\FormatTelegramLink', // класс обработчик пользовательского типа UF поля
        'GetUserTypeDescription'
    ]
);
