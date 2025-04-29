<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle(""); ?><?php
global $APPLICATION;
$APPLICATION->setTitle("Список врачей");

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
use Models\Lists\DoctorsPropertyValuesTable;
use Bitrix\Main\UI\Extension;

Extension::load('ui.bootstrap4');
Loader::includeModule('iblock');

$iblockId = 18;
$dbItems = \Bitrix\Iblock\ElementTable::getList(array(
    'select' => array('ID', 'NAME', 'IBLOCK_ID'),
    'filter' => array('IBLOCK_ID' => $iblockId)
));
$items = [];
while ($arItem = $dbItems->fetch()) {
    $dbProperty = \CIBlockElement::getProperty(
        $arItem['IBLOCK_ID'],
        $arItem['ID']
    );
    while ($arProperty = $dbProperty->Fetch()) {
        $arItem['PROPERTIES'][$arProperty['CODE']] = $arProperty;
    }

    $items [] = $arItem;
}


?>

<div class="container ">
    <div class="row">
        <div class="col">
            <h1 class="text-center">Врачи2222</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="new" class="btn btn-primary">Добавить врача</a>
            <a href="newproc" class="btn btn-secondary">Добавить процедуру</a>
        </div>
    </div>
    <div class="row ">
        <?php foreach ($items as $item) { ?>
            <div class="col mt-5 text-center">
                <a href="/doctors/detail.php?id=<?= $item['ID']?>">
                    <div class="card border-info mb-3" style="max-width: 18rem;">
                        <div class="card-body text-info">
                            <h5 class="card-title"><?= $item['PROPERTIES']['LAST_NAME']['VALUE'] ?> <?= $item['PROPERTIES']['FIRST_NAME']['VALUE'] ?> <?= $item['PROPERTIES']['MIDDLE_NAME']['VALUE'] ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>

    </div>


</div>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>