<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>
<?php
global $APPLICATION;
$APPLICATION->setTitle("Врач " . $_GET['name']);

use Bitrix\Main\UI\Extension;

use Models\lists\DoctorsPropertyValuesTable as DoctorsTable;
use Models\lists\ProceduresPropertyValuesTable as ProceduresTable;

Extension::load('ui.bootstrap4');
$docId = $_GET['id']; // идентификатор доктора из инфоблока Доктора

if (!empty($_REQUEST['ID'])) {

    $el = new \CIBlockElement;
    $PROP = array();
    $PROP[65] = $_REQUEST['FIRST_NAME'];  // свойству с кодом 12 присваиваем значение "Белый"
    $PROP[67] = $_REQUEST['LAST_NAME'];        // свойству с кодом 3 присваиваем значение 38
    $PROP[66] = $_REQUEST['MIDDLE_NAME'];        // свойству с кодом 3 присваиваем значение 38
    $PROP[69] = $_REQUEST['PROC_IDS_MULTI'];        // свойству с кодом 3 присваиваем значение 38

    $arLoadProductArray = array(
        "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
        "PROPERTY_VALUES" => $PROP,
        "NAME" => $_REQUEST['NAME'],
    );
    $PRODUCT_ID = intval($_REQUEST['ID']);  // изменяем элемент с кодом (ID) 2
    $result = $el->Update($PRODUCT_ID, $arLoadProductArray);

}

$doctors = DoctorsTable::query()
    ->setSelect([
        '*',
        'PROC_IDS_MULTI',
        'ID' => 'ELEMENT.ID',
        'NAME' => 'ELEMENT.NAME',
    ])
    ->setFilter([
        'ID' => $docId,
    ])
    ->setOrder(['NAME' => 'desc'])
    ->fetchAll();
$procedures = array();
$arFilter = ['IBLOCK_ID' => 19, 'ACTIVE' => 'Y'];
$arSelect = ['NAME', 'ID'];
$res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
while ($arFields = $res->fetch()) {
    $procedures[] = $arFields;
}


?>


<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="text-center">Врачи</h1>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center">Данные врача</h1>
            <div class="col-md-6 offset-md-3 mt-3">
                <?php if ($result == true): ?>
                    <div class="alert alert-success text-center" role="alert">
                        Вы успешно обновили врача
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 offset-md-3">
            <form class="row g-3 needs-validation" novalidate method="post">
                <input type="hidden" name="ID" value="<?= $doctors['0']['ID'] ?>">
                <div class="col-12">
                    <input type="text" name="LAST_NAME" class="form-control" id="lastName" placeholder="Фамилия"
                           value="<?= $doctors['0']['LAST_NAME'] ?>" required>
                    <div class="valid-feedback">
                        Все хорошо!
                    </div>
                </div>
                <div class="col-12">
                    <input type="text" name="FIRST_NAME" class="form-control" id="firstName" placeholder="Имя"
                           value="<?= $doctors['0']['FIRST_NAME'] ?>" required>
                    <div class="valid-feedback">
                        Все хорошо!
                    </div>
                </div>
                <div class="col-12">
                    <input type="text" name="MIDDLE_NAME" class="form-control" id="middleName" placeholder="Отчество"
                           value="<?= $doctors['0']['MIDDLE_NAME'] ?>" required>
                    <div class="valid-feedback">
                        Все хорошо!
                    </div>
                </div>
                <div class="col-12">
                    <select class="form-select" name="PROC_IDS_MULTI[]" multiple
                            aria-label="пример множественного выбора">
                        <option selected disabled>Откройте это меню выбора</option>
                        <?php foreach ($procedures as $procedure): ?>
                            <?php
                            array_unshift($doctors['0']['PROC_IDS_MULTI'], "");
                            unset($doctors['0']['PROC_IDS_MULTI'][0]);
                            $key = array_search($procedure['ID'], $doctors['0']['PROC_IDS_MULTI']);
                            ?>
                            <option value="<?= $procedure['ID'] ?>" <?php if ($key > 0) {
                                echo 'selected';
                            } ?>><?= $procedure['NAME'] ?></option>
                            <?php ?>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
