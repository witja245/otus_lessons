<?php

namespace UserTypes;

class CUserTypeOnLineRecord
{
    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S', // тип поля
            'USER_TYPE' => 'ONLINE_RECORD', // код типа пользовательского свойства
            'DESCRIPTION' => 'Онлайн запись', // название типа пользовательского свойства
            'GetPropertyFieldHtml' => array(self::class, 'GetPropertyFieldHtml'), // метод отображения свойства
            'GetPublicViewHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения

            'GetPublicEditHTML' => array(self::class, 'GetPropertyFieldHtml'), // метод отображения значения в форме редактирования

        );

    }

    public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
    {
        $strResult = '<button id="onl-btn-9129961501" type="button"></button>';

        return $strResult;
    }

    public static function getDataValues($id)
    {

        $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
            'select' => [
                'ID',
                'NAME',
                'FIRST_NAME',
                'MIDDLE_NAME',
                'LAST_NAME',
                'PROC_IDS_MULTI.ELEMENT.NAME',
                'PROC_IDS_MULTI.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле Процедуры у элемента инфоблока Доктора
            ],
            'filter' => [
                'ID' => $id,
                'ACTIVE' => 'Y',
            ],
        ])
            ->fetchCollection();

        $procedures = [];
        foreach ($doctors as $doctor) {
            foreach ($doctor->getProcIdsMulti()->getAll() as $key => $prItem) {
                if (!empty($prItem->getElement()->getName())):
                    $procedures[$key]['ID'] = $prItem->getElement()->getId();
                    $procedures[$key]['NAME'] = $prItem->getElement()->getName();
                endif;
            }
        }

        return $procedures;
    }

    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        \CJSCore::Init(['popup']);
        \CJSCore::Init(array("jquery"));
        \Bitrix\Main\UI\Extension::load("ui.forms");
//         pr($arProperty);
//         pr($arValue);
//         pr($strHTMLControlName);

        $procedures = self::getDataValues($arProperty['ELEMENT_ID']);
        $strResult = '';

        foreach ($procedures as $procedure) {
            $strResult .= '<a href="javascript:void(0)" onclick="openFormPopup(' . $procedure['ID'] . ', ' . $arProperty['ELEMENT_ID'] . ')">' . $procedure['NAME'] . '</a><br>';
        }

        $formstr  = '';
        $formstr .= '<br/><h1 class="text-center">Онлайн запись</h1><br/>';
        $formstr .= '<div class="result" style="color:red"></div><br/>';
        $formstr .= '<div class="ui-ctl ui-ctl-textbox"><input type="text" id="name" name="name" class="ui-ctl-element" placeholder="Ваше Имя"></div><br/>';
        $formstr .= '<div class="ui-ctl ui-ctl-textbox"><input type="datetime-local" id="data" name="data" class="ui-ctl-element" placeholder="Ваше Имя"></div>';
        $formstr .= '<input type="hidden" id="doctorsId" name="doctorsId" value="'.$arProperty['ELEMENT_ID'].'" >';

        $strResult .= "
        <script>
    function openFormPopup(procedureId, doctorsId) {
        var authPopup = BX.PopupWindowManager.create('FormPopup', null, {
            autoHide: true,
            width: 300, // ширина окна
            height: 350, // высота окна
            offsetLeft: 0,
            offsetTop: 0,
            overlay: true,
            draggable: {restrict: true},
            closeByEsc: true,
            closeIcon: {right: '12px', top: '10px'},
            content: '".$formstr."',
            events: {
                onAfterPopupShow: function () {
                    this.setContent(BX('bx_recall_popup_form'));
                }
            },
            buttons: [
                new BX.PopupWindowButton({
                    text: 'Добавить запись',
                    className: 'popup-window-button-accept',
                    events: {
                        click: function () {
                            let name = document.getElementById('name').value;
                            let data = document.getElementById('data').value;
                            console.log('name='+name)
                            console.log('data='+data)
                            console.log('doctorsId='+doctorsId)
                            console.log('procedureId='+procedureId)
                            BX.ajax({
                                url: '/ajax/onlineRecordingAjax.php',
                                method: 'POST',
                                data: {name: name, data:data, doctorsId:doctorsId, procedureId:procedureId},
                                onsuccess: function(result) {
                                    var data = JSON.parse(result);
                                    if (data.success) {
                                        alert(data.message);
                                        authPopup.close();
                                        
                                    }
                                    if (data.errors) {
                                        document.querySelector('.result').textContent = data.message;
                                    }
                                },
                                onfailure: function() {
                                    alert('Ошибка при выполнении запроса');
                                }
                            });
                           
                        }
                    }
                }),

            ],
        });

        authPopup.show();
    }
</script>
        ";


        return $strResult;


    }

  
}
