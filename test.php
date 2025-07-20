<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Otus\Rest\Events;
use Otus\Rest\OriginalContactsDataTable;
$query = OriginalContactsDataTable::getList([
    'select' => ['*'],
    'filter' => [],
    'limit' => 10,
    'offset' => 0
])->fetchAll();
pr($query);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');