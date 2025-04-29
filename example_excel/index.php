<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");

?><?$APPLICATION->IncludeComponent(
    "otus:book.grid",
    "",
    array()
);?>
<?php  require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');