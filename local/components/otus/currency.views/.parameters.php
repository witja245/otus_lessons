<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("currency"))
	return;
$currencyList = \Bitrix\Currency\CurrencyManager::getCurrencyList();
$arComponentParameters = array(
	"GROUPS" => array(
		"LIST"=>array(
			"NAME"=>GetMessage("GRID_PARAMETERS"),
			"SORT"=>"300"
		)
	),
	"PARAMETERS" => array(
        'CURRENCY' => array(
            'PARENT' => 'LIST',
            'NAME' => GetMessage("CURRENCY_PARAMETERS"),
            'TYPE' => 'LIST',
            'VALUES' => $currencyList,
            "DEFAULT" => '',
        ),
	)
);


