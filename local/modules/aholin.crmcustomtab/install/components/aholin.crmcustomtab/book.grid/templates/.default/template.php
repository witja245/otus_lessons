<?php

use Bitrix\Main\Web\Json;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/**
 * @var array $arResult
 * @var array $arParams
 * @global $APPLICATION
 * @global $component
 */

\Bitrix\Main\Loader::includeModule('ui');
$APPLICATION->IncludeComponent(
    'bitrix:main.ui.filter',
    '',
    [
        'FILTER_ID' => $arResult['FILTER_ID'],
        'GRID_ID' => $arResult['FILTER_ID'],
        'ENABLE_FIELDS_SEARCH' => false,
        'FILTER' => $arResult['UI_FILTER'],
        'ENABLE_LIVE_SEARCH' => true,
        'ENABLE_LABEL' => true
    ]);

?>

<?php
$APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID' => $arResult['FILTER_ID'],
        'HEADERS' => $arResult['HEADERS'],
        'ROWS' => $arResult['GRID_LIST'],
        'TOTAL_ROWS_COUNT' => $arResult['NAV']->getRecordCount(),
        'NAV_OBJECT' => $arResult['NAV'],
        'FILTER_STATUS_NAME' => '',
        'AJAX_MODE' => 'Y',
        'AJAX_OPTION_JUMP' => 'N',
        'AJAX_OPTION_STYLE' => 'N',
        'AJAX_OPTION_HISTORY' => 'N',
        'AJAX_LOADER' => $arParams['AJAX_LOADER'],
        'AJAX_ID' => \CAjax::getComponentID(
            'bitrix:main.ui.grid',
            '.default',
            ''
        ),
        'ALLOW_COLUMNS_SORT' => true,
        'ALLOW_ROWS_SORT' => [],
        'ALLOW_COLUMNS_RESIZE' => true,
        'ALLOW_HORIZONTAL_SCROLL' => true,
        'ALLOW_SORT' => true,
        'ALLOW_PIN_HEADER' => true,
        'ACTION_PANEL' => [],

        'SHOW_CHECK_ALL_CHECKBOXES' => false,
        'SHOW_ROW_CHECKBOXES' => false,
        'SHOW_ROW_ACTIONS_MENU' => true,
        'SHOW_GRID_SETTINGS_MENU' => true,
        'SHOW_NAVIGATION_PANEL' => true,
        'SHOW_PAGINATION' => true,
        'SHOW_SELECTED_COUNTER' => true,
        'SHOW_TOTAL_COUNTER' => true,
        'SHOW_PAGESIZE' => true,
        'SHOW_ACTION_PANEL' => true,

        'ENABLE_COLLAPSIBLE_ROWS' => true,
        'ALLOW_SAVE_ROWS_STATE' => true,

        'SHOW_MORE_BUTTON' => false,
        'CURRENT_PAGE' => '',
        'DEFAULT_PAGE_SIZE' => 20,
        'PAGE_SIZES' => [
            ['NAME' => 1, 'VALUE' => 1],
            ['NAME' => 5, 'VALUE' => 5],
            ['NAME' => 10, 'VALUE' => 10],
            ['NAME' => 20, 'VALUE' => 20],
            ['NAME' => 50, 'VALUE' => 50],
        ],
    ],
    $component,
);
if (!empty($arParams['AJAX_LOADER'])) { ?>
    <script>
        BX.addCustomEvent('Grid::beforeRequest', function (gridData, argse) {
            if (argse.gridId !== '<?=$arResult['FILTER_ID'];?>') {
                return;
            }

            if (argse.url === '') {
                argse.url = "<?=$component->getPath()?>/lazyload.ajax.php?site=<?=\SITE_ID?>&internal=true&grid_id=<?=$arResult['FILTER_ID']?>&grid_action=filter&"
            }

            argse.method = 'POST'
            argse.data = <?= Json::encode($arParams['AJAX_LOADER']['data']) ?>;
        });
    </script>
<?php } ?>
