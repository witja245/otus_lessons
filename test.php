<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Bitrix\Crm\CompanyTable;
use Bitrix\Main\Entity\ReferenceField;

$el = new CIBlockElement;
$PROP = array();

$PROP['83'] = 1;  // свойству Сумма
$PROP['84'] = 100;  // свойству Сумма
$PROP['85'] = 1;        // свойству Ответственный
$arLoadProductArray = Array(
    "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
    "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
    "PROPERTY_VALUES"=> $PROP,

);
$PRODUCT_ID = 85;  // изменяем элемент с кодом (ID) 2
$res = $el->Update($PRODUCT_ID, $arLoadProductArray);

pr($res);








?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');