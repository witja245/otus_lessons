<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');




CModule::IncludeModule('iblock');
$date = date("d.m.Y H:i:s", strtotime("2025-05-23T02:01"));
$arFilter = array(
    "IBLOCK_ID" => IntVal(20),
    "ACTIVE" => "Y",
    "DOCTORS" => 55,
    "PROTSEDURA" => 56,
    "RECORDING_TIME" => $date,
);
$elements = \Bitrix\Iblock\Elements\ElementBookingTable::getList([
    'select' => ['*','DOCTORS', 'PROTSEDURA', 'RECORDING_TIME'],
    'filter' => $arFilter,
])->fetchAll();

pr($elements);











?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');