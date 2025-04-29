<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Bitrix\Main\Loader;
use Witja\CrmCustomTab\lib\Orm\ContractsTable;
Loader::includeModule('witja.crmcustomtab');
//$contracts = ContractsTable::getList([
//    'filter' => [],
//    'select' => [
//        'ID',
//        'NAME',
//        'DATE_CREATE',
//        'DATE_MODIFY',
//        'UF_SUMMA',
//        'UF_DATE_SIGN',
//        'UF_NUMBER',
//        'UF_STATUS',
//        'CONTACT_NAME' => 'CONTACT.NAME',
//        'CONTACT_LAST_NAME' => 'CONTACT.LAST_NAME',
//        'CONTACT_SECOND_NAME' => 'CONTACT.SECOND_NAME',
////                    'AUTHOR_FIRST_NAME' => 'AUTHORS.FIRST_NAME',
////                    'AUTHOR_LAST_NAME' => 'AUTHORS.LAST_NAME',
////                    'AUTHOR_SECOND_NAME' => 'AUTHORS.SECOND_NAME',
//    ],
//]);
//while ($contract = $contracts->fetch()) {
//    pr($contract);
//}

$APPLICATION->IncludeComponent(
    "otus:contracts.grid",
    "",
    Array(),
    false
);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');