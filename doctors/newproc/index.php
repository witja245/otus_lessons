<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php'); ?>
<?php
global $APPLICATION;
$APPLICATION->setTitle("Добавить процедуру");

use Bitrix\Main\UI\Extension;


Extension::load('ui.bootstrap4');
$procedures = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([ // car - cимвольный код API инфоблока
    'select' => ['*'], // имя свойства
])->fetchCollection();

if (!empty($_REQUEST['NAME'])) {
    $arElementProps = [
        'DESCRIPTION' => $_REQUEST['DESCRIPTION'],
    ];
    $arIblockFields = [
        'IBLOCK_ID' => 19,
        'NAME' => $_REQUEST['NAME'],
        'PROPERTY_VALUES' => $arElementProps
    ];

    $objIblockElement = new \CIBlockElement();
    $result = $objIblockElement->Add($arIblockFields);

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
                <h1 class="text-center">Добавить процедуру</h1>
                <div class="col-md-6 offset-md-3 mt-3">
                    <?php if (!empty($result)): ?>
                        <div class="alert alert-success text-center" role="alert">
                            Вы успешно добавили процедуру
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                        <input type="text" name="NAME" class="form-control" id="NAME" value=""
                               placeholder="Название процедуры" required>
                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
                    </div>

                    <div class="col-12">
                        <textarea class="form-control" name="DESCRIPTION" id="DESCRIPTION" rows="3"  placeholder="Описание процедуры"></textarea>

                        <div class="valid-feedback">
                            Все хорошо!
                        </div>
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