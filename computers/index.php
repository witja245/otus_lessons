<?php
/**
 * @global  \CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Компьютеры');

use Bitrix\Main\UI\Extension;

Extension::load('ui.bootstrap4');

use Models\ComputerTable as Computers;


$collection = Computers::getList([
    'select' => [
        'name',
        'text',
        'articul',
        'SHOP_NAME' => 'SHOP.NAME',
        'SHOP_ADRESS' => 'SHOP.ADRESS.VALUE',
        'MANUFACTURE_NAME' => 'MANUFACTURE.NAME'
    ]
])->fetchAll();

?>
    <ol class="list-group list-group-numbered">
        <?php foreach ($collection as $key => $comp) : ?>
            <li class="list-group-item">
                <h3><?=$key+1?>. <?= $comp['name'] ?> </h3>
                <p><?= $comp['text'] ?></p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Артикул</strong> - <?= $comp['articul'] ?></li>
                    <li class="list-group-item"><strong>Производитель</strong> - <?= $comp['MANUFACTURE_NAME'] ?>
                    </li>
                    <li class="list-group-item"><strong>Магазин</strong> - <?= $comp['SHOP_NAME'] ?>
                        <p>адрес магазина: <?= $comp['SHOP_ADRESS'] ?></p>
                    </li>
                    <li class="list-group-item"><strong>Цена</strong> - <?= $comp['price'] ?> руб.</li>
                </ul>
            </li>
        <?php endforeach; ?>

    </ol>



<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');

