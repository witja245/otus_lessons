<?php
require_once(__DIR__ . '/crest.php');

if (empty($_REQUEST['event'])) {
    ?>
    <div>Приложение используется как обработчик события</div>
    <?php
}
//$json_data = json_encode($_REQUEST);
//file_put_contents('/home/c/co75635/otus/public_html/server-app-deals/data.json', $json_data);
if ($_REQUEST['event'] === 'ONCRMACTIVITYADD') {

    $activityId = $_REQUEST['data']['FIELDS']['ID'];

    //@ TODO реализовать получение информации о деле CRM
    $result = CRest::call(
        'crm.activity.get',
        [
            'id' => intval($activityId),
        ],
    );
//    $json_data2 = json_encode($result);
//    file_put_contents('/home/c/co75635/otus/public_html/server-app-deals/data2.json', $json_data2);

    // @TODO если дело является звонком или сообщением, то обновить поле "Дата коммуникации"

    $result22 = CRest::call(
        'crm.contact.update',
        [
            'ID' => $result['result']['OWNER_ID'],
            'FIELDS' => [
                'UF_DATE_COMMUNICATION' => date('d.m.Y H:i:s'),

            ],
        ],

    );

//        $json_data3 = json_encode($result22);
//        file_put_contents('/home/c/co75635/otus/public_html/server-app-deals/data3.json', $json_data3);

}


