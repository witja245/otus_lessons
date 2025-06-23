<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Bitrix\Crm\CompanyTable;
use Bitrix\Main\Entity\ReferenceField;


// Получение элементов

CModule::IncludeModule('iblock');

// Создаем объект для работы с инфоблоком
$el = new CIBlockElement;

// Массив свойств
$PROP = array(
    83 => 6,
    84 => 5,
    85 => 3,
);

// Массив данных для обновления
$arLoadProductArray = array(
    'PROPERTY_VALUES' => $PROP,
);

// Выполняем обновление
if ($newElement = $el->Update(87, $arLoadProductArray)) {
    echo "Элемент обновлен: " . $newElement;
} else {
    echo "Ошибка: " . $el->LAST_ERROR;
}


?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');