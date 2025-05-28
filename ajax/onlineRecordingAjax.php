<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

if (empty($_REQUEST['name'])) {
    // Ваш код обработки
    $result = [
        'errors' => true,
        'message' => 'Вы не указали свое имя'
    ];

    echo json_encode($result);
    die();
}
if (empty($_REQUEST['data'])) {
    // Ваш код обработки
    $result = [
        'errors' => true,
        'message' => 'Вы не указали дату записи'
    ];

    echo json_encode($result);
    die();
}

if (!empty($_REQUEST['name']) && !empty($_REQUEST['data'])) {
    $date = date("d.m.Y H:i:s", strtotime($_REQUEST['data']));


    $el = new CIBlockElement;
    $PROP = array();
    $PROP[73] = $_REQUEST['doctorsId'];
    $PROP[74] = $_REQUEST['name'];
    $PROP[75] = $_REQUEST['procedureId'];
    $PROP[76] = $date;

    $arLoadProductArray = array(
        "ACTIVE_FROM" => date('d.m.Y H:i:s'),
        "IBLOCK_ID" => 20,
        "NAME" => $_REQUEST['name'],
        "PROPERTY_VALUES" => $PROP,
    );
    if ($newElement = $el->Add($arLoadProductArray)) {
        $result = [
            'success' => true,
            'message' => "ID нового элемента: " . $newElement
        ];
        echo json_encode($result);
    } else {
        $result = [
            'errors' => true,
            'message' => $el->LAST_ERROR
        ];
        echo json_encode($result);
    }
}