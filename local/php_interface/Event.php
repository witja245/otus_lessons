<?php
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MyClass", "OnAfterIBlockElementUpdateHandler"));
class MyClass
{
    // создаем обработчик события "OnAfterIBlockElementUpdate"
    public static function OnAfterIBlockElementUpdateHandler(&$arFields)
    {

        $entityId = intval($arFields['PROPERTY_VALUES']['83']['177']['VALUE']);
        $entityFields = [
            // Отметим сделку выполненной
            'OPPORTUNITY'   => (int)$arFields['PROPERTY_VALUES']['84']['178'],
            'ASSIGNED_BY_ID'   => intval($arFields['PROPERTY_VALUES']['85']),
        ];
        $entityObject = new \CCrmDeal(true);
        $isUpdateSuccess = $entityObject->Update(
            $entityId,
            $entityFields,
            $bCompare = true,
            $bUpdateSearch = true,
        );
        if ( !$isUpdateSuccess )
        {
            echo $entityObject->LAST_ERROR;
            return false;
        }
    }
}

AddEventHandler("crm", "OnAfterCrmDealUpdate", "MyOnAfterCrmDealUpdate");
function MyOnAfterCrmDealUpdate($arFields){
    $arFilter = [
        'IBLOCK_ID' => 22, // ID инфоблока
        'PROPERTY_DEAL' => $arFields["ID"] // Название свойства и его значение
    ];

    $res = CIBlockElement::GetList(
        [],
        $arFilter,
        false,
        false,
        ['ID']
    );

    while ($ob = $res->GetNextElement()) {
        $fields['0'] = $ob->GetFields();

    }

    if (!empty($fields)) {
        $el = new CIBlockElement;
        $PROP = array();

        $PROP['83'] = intval($arFields['ID']);  // свойству Сумма
        $PROP['84'] = intval($arFields['OPPORTUNITY']);  // свойству Сумма
        $PROP['85'] = intval($arFields['ASSIGNED_BY_ID']);        // свойству Ответственный

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
            "PROPERTY_VALUES"=> $PROP,

        );

        $PRODUCT_ID = intval($fields['0']['ID']);
        $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    }

}