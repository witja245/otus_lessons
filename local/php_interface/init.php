<?php

include_once __DIR__ . '/classes/BXHelper.php';

use Bitrix\Main\Diag;
use Psr\Log\logLevel;

if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php");
}
if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php");
}

if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php");
}
if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/Event.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/Event.php");
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

\Bitrix\Main\UI\Extension::load([
//    'aholin_crmcustomtab.useless_extensions.greeting-message',
    'dev_helper.log_events',
//    'ajax.all_ajax_handler',
//    'otus_crm.negative_currency',
    'homework.begin_date_button',
]);

/**

 * Запись в лог

 * @param $logInfo

 * @return void

 */

function tl($logInfo, $file = "main", $maxLogSize = 1048576000)

{
    $logFile = $_SERVER["DOCUMENT_ROOT"] . "/log/" . $file . "_log.txt";
    $logger = new Diag\FileLogger($logFile, $maxLogSize);
    $logger->setLevel(LogLevel::DEBUG);
    $formatter = new Diag\LogFormatter(false);
    $logger->setFormatter($formatter);
    $showArgs = false;
    $trace      = '';
    $traceDepth = 6;
    if ($traceDepth > 0) {
        $trace = Diag\Helper::getBackTrace($traceDepth, ($showArgs ? null : DEBUG_BACKTRACE_IGNORE_ARGS), 2);
    }

    $context = [
        'message' => $logInfo,
        'host' => $_SERVER["SCRIPT_FILENAME"] . " - " . $_SERVER["REMOTE_ADDR"],
        'trace' => $trace,
    ];

    $message = "{host}\n"
        . "Date: {date}\n"
        . "{message}\n"
        . "{delimiter}\n";

    $logger->debug(
        $message,
        $context
    );

    AddMessage2Log($logInfo);

}