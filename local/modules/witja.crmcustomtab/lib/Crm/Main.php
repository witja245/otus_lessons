<?php
namespace Witja\Crmcustomtab\Crm;

use Witja\CrmCustomTab\lib\Orm\ContractsTable;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);
class Main
{
    public static $tabName = 'CRM_ENITY_TAB_NAME';
    public static $typeCrm = 'CRM_ENITY_TYPE_ID';
    public static function getModuleId(): string
    {
        return 'witja.crmcustomtab';
    }

    /**
     * @return string
     *
     * Наименование вкладки
     */
    public static function getNameTab(): string
    {
        return Option::get(self::getModuleId(), self::$tabName);
    }

    /**
     * @return string
     *
     * Тип CRM
     */
    public static function getTypeCrm(): string
    {
        return Option::get(self::getModuleId(), self::$typeCrm);
    }
}
