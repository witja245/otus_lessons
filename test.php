<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Otus\Rest\Events;
use Otus\Rest\ContractsTable;
$arfields = [
    'contract_number'=>'Д-001/2025',
    'client_name'=>'тест',
//    'contract_date'=>'2025-12-31',
    'contract_date'=>'15.01.2025',

];
$result = ContractsTable::add($arfields);
if ($result->isSuccess()) {
    echo "Элемент успешно добавлен. ID: " . $result->getId();
} else {
    echo "Ошибка при добавлении элемента: " . $result->getError()->getMessage();
}
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');