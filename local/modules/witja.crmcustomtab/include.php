<?php

IncludeModuleLangFile(__FILE__);

/**
 *
 */


CModule::AddAutoloadClasses('witja.crmcustomtab', [

    /**
     * Класс для работы с ORM
     */

    'Witja\Crmcustomtab\Crm\Main' => '/lib/Crm/Main.php',
    'Witja\CrmCustomTab\lib\Orm\ContractsTable' => '/lib/Orm/ContractsTable.php',






]);