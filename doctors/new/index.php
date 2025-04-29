<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>
<?php
global $APPLICATION;
$APPLICATION->setTitle("Добавить врача");

use Bitrix\Main\UI\Extension;

use Models\lists\DoctorsPropertyValuesTable as DoctorsTable;
Extension::load('ui.bootstrap4');
$procedures = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([ // car - cимвольный код API инфоблока
    'select' => ['*'], // имя свойства
])->fetchCollection();
$result = false;

if (!empty($_REQUEST['NAME'])) {
    $arFields = Array(
        'NAME' => $_REQUEST['NAME'],
        'FIRST_NAME'=>$_REQUEST['FIRST_NAME'],
        'LAST_NAME'=>$_REQUEST['LAST_NAME'],
        'MIDDLE_NAME'=>$_REQUEST['MIDDLE_NAME'],
        'PROC_IDS_MULTI'=>$_REQUEST['PROC_IDS_MULTI'],
    );

    $result = DoctorsTable::add($arFields);

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
                            Вы успешно добавили врача
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form class="row g-3 needs-validation" novalidate method="post">
                    <div class="col-12">
                        <input type="text" name="NAME" class="form-control" id="lastName" value=""
                               placeholder="Название страницы врача (фамилия латиницей)" required>
                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" name="LAST_NAME" class="form-control" id="lastName"
                               placeholder="Фамилия врача" value="" required>
                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" name="FIRST_NAME" class="form-control" id="firstName" placeholder="Имя врача"
                               value="" required>
                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" name="MIDDLE_NAME" class="form-control" id="middleName"
                               placeholder="Отчество врача" value="" required>
                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
                    </div>
                    <div class="col-12">
                        <select class="form-select" name="PROC_IDS_MULTI[]" multiple aria-label="пример множественного выбора">
                            <option disabled>Процедуры</option>
                            <?php foreach ($procedures as $procedur): ?>
                                <option value="<?= $procedur->getId() ?>"><?= $procedur->getName() ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Добавить врача</button>
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