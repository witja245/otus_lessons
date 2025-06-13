<?php
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("MyClass", "OnAfterIBlockElementUpdateHandler"));

class MyClass
{
    public static function OnAfterIBlockElementUpdateHandler(&$arFields)
    {

        foreach ($arFields['PROPERTY_VALUES']['83'] as $dealsId) {
            $Id = intval($dealsId['VALUE']);

        }
        foreach ($arFields['PROPERTY_VALUES']['84'] as $ammount) {
            $summ = $ammount;
        }

        $dealId = $Id; // ID сделки
        $newAmount = $summ; // Новая сумма
        $arField =  [
            'OPPORTUNITY' => $newAmount,
            'ASSIGNED_BY_ID' => intval($arFields['PROPERTY_VALUES']['85']),
            'CURRENCY_ID' => 'RUB' // Указываем валюту
        ];

        $deal = new CCrmDeal(true);
        $result = $deal->Update(
            $dealId,
            $arField
        );

        if (!$result) {
            return false;
        }
    }
}

AddEventHandler("crm", "OnAfterCrmDealUpdate", "MyOnAfterCrmDealUpdate");
function MyOnAfterCrmDealUpdate($arFields)
{
    $elements = CIBlockElement::GetList(
        array(),
        ['IBLOCK_ID' => 22, 'PROPERTY_DEAL' => $arFields['ID']],
        false,
        false,
        ['ID']
    );


    while($element = $elements->GetNextElement()) {
        $fields = $element->GetFields();
        $iblockElementId = $fields['ID'];
    }

    CModule::IncludeModule('iblock');


    $el = new CIBlockElement;


    $PROP = array(
        83 => $arFields['ID'],
        84 => $arFields['OPPORTUNITY'],
        85 => $arFields['ASSIGNED_BY_ID'],
    );


    $arLoadProductArray = array(
        'PROPERTY_VALUES' => $PROP,
    );

// Выполняем обновление
    if ($newElement = $el->Update($iblockElementId, $arLoadProductArray)) {
        tl('Элемент обновлен:', 'result');
    } else {
        tl('Ошибка:'. $el->LAST_ERROR, 'result');

    }
}