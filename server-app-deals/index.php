<?php
require_once (__DIR__.'/crest.php');

if (empty($_REQUEST['event'])) {
    ?>
    <div>Приложение используется как обработчик события</div>
    <?php
}

if ($_REQUEST['event'] === 'onCrmActivityAdd') {


    $activityId = $_REQUEST['data']['fields']['ID'];
    //@ TODO реализовать получение информации о деле CRM
    $result = CRest::call(
        'crm.activity.get',
        [
            'id' => $activityId,
        ],
    );
    // @TODO если дело является звонком или сообщением, то обновить поле "Дата коммуникации"

    if ($result['result']['PROVIDER_TYPE_ID'] == 'CALL' || $result['result']['PROVIDER_TYPE_ID'] == 'EMAIL') {
        $result = CRest::call(
            'crm.contact.update',
            [
                'ID' => $result['result']['OWNER_ID'],
                'FIELDS' => [
                    'UF_DATE_COMMUNICATION' => date('d.m.Y H:i:s'),

                ],
            ],

        );
    }
}


