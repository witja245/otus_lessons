<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$nav = new \Bitrix\Main\UI\PageNavigation('report_list');
$nav->setRecordCount($arResult['COUNT']);
$nav->allowAllRecords(false)->setPageSize($arResult['NUM_PAGE'])->initFromUri();


// echo 'TEMPLATE';
// pr($arParams);
// pr($arResult);
// pr($templateFolder); 
// pr($componentPath); 
?>

<p>Выбран текущий курс валюты <?=$arResult['ITEMS']['CURRENCY']?> - <?=$arResult['ITEMS']['AMOUNT']?></p>