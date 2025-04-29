<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>
<?php
global $APPLICATION;
$APPLICATION->setTitle("Врач " . $_GET['name']);

use Bitrix\Main\UI\Extension;
use Models\lists\DoctorsPropertyValuesTable as DoctorsTable;

Extension::load('ui.bootstrap4');
//$codeName = $_GET['name']; // идентификатор доктора из инфоблока Доктора
//
//
//$docId = $_GET['id']; // идентификатор доктора из инфоблока Доктора
//$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
//    'select' => [
//        'ID',
//        'NAME',
//        'LAST_NAME',
//        'FIRST_NAME',
//        'MIDDLE_NAME',
//        'PROC_IDS_MULTI.ELEMENT.NAME',
//        'PROC_IDS_MULTI.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле Процедуры у элемента инфоблока Доктора
//    ],
//    'filter' => [
//        'ID' => $docId,
//        'ACTIVE' => 'Y',
//    ],
//])
//    ->fetchCollection();
$docId = $_GET['id']; // идентификатор доктора из инфоблока Доктора
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
        'ID' => $docId,
        'ACTIVE' => 'Y',
    ],
])
    ->fetchCollection();


?>
    <div class="container ">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Врачи</h1>
            </div>
        </div>
        <?php foreach ($doctors as $doctor): ?>
            <div class="row">
                <div class="col">
                    <a href="/doctors/edit/?id=<?= $doctor->getId() ?>" class="btn btn-primary">Изменить данные
                        врача</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <h3><?= $doctor->getLastName()->getValue() ?> <?= $doctor->getFirstName()->getValue() ?> <?= $doctor->getMiddleName()->getValue() ?></h3>
                </div>
            </div>
            <div class="row ">
                <div class="col mt-3">
                    <ol class="list-unstyled">
                        <li><h5>Процедуры:</h5>
                            <ul>
                                <?php foreach ($doctor->getProcIdsMulti()->getAll() as $prItem) { ?>
                                    <?php if (!empty($prItem->getElement()->getName())): ?>
                                        <li><?= $prItem->getElement()->getName() ?></li>
                                    <?php endif; ?>
                                <?php } ?>

                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>