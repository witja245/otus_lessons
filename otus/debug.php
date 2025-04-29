<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$date = date('d.m.Y H:i:s');
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logs/task_1.log', $date, PHP_EOL, FILE_APPEND);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');