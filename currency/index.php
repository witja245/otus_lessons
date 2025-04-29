<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");

?><?$APPLICATION->IncludeComponent(
    "otus:currency.views",
    ".default",
    array(
        "CURRENCY" => "RUB",
    )
);?>