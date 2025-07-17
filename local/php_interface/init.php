<?php
//if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php")){
//    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/vendor/autoload.php");
//}
//if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php")){
//    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/src/autoload.php");
//}
//
//if (filectime($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php")){
//    require_once($_SERVER["DOCUMENT_ROOT"]."/local/app/autoload.php");
//}

function pr($var, $type = false) {
    echo '<pre style="font-size:10px; border:1px solid #000; background:#FFF; text-align:left; color:#000;">';
    if ($type)
        var_dump($var);
    else
        print_r($var);
    echo '</pre>';
}

require_once ($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/rest/events.php');
require_once ($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/rest/ContractsTable.php');

\Bitrix\Main\Loader::registerAutoLoadClasses(
    null, // Имя вашего модуля
    [
        // Класс => относительный путь от папки модуля
        'Otus\Rest\Events' => '/local/php_interface/include/rest/events.php',
        'Otus\Rest\ContractsTable' => '/local/php_interface/include/rest/ContractsTable.php',

    ]
);
