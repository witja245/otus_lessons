<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Grid\Options;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\UI\PageNavigation;

class CCheckTransportTableSignator extends CBitrixComponent
{



    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    public function onPrepareComponentParams($arParams)
    {
        // время кеширования
        if (!isset($arParams['CACHE_TIME'])) {
            $arParams['CACHE_TIME'] = 3600;
        } else {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        }
        // возвращаем в метод новый массив $arParams

        return $arParams;
    }

    public function executeComponent()
    {
        $this->arResult['ITEMS'] = $this->getCurrency();

        $this->includeComponentTemplate();
    }

    public function getCurrency()
    {
        CModule::IncludeModule('currency');
        $Currency = Bitrix\Currency\CurrencyTable::getList([
            'filter' => [
                'CURRENCY' => $this->arParams['CURRENCY'],
            ]
        ])->fetch();

        return $Currency;
    }

}