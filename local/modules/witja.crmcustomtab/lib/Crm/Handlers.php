<?php
namespace Witja\Crmcustomtab\Crm;


use Witja\Crmcustomtab\Crm\Main;
use Witja\CrmCustomTab\lib\Orm\ContractsTable;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Localization\Loc;


Loc::loadMessages(__FILE__);
class Handlers
{
    public static function updateContactsTabs(Event $event): EventResult
    {
        $entityTypeId = $event->getParameter('entityTypeID');
        $entityId = $event->getParameter('entityID');
        $tabs = $event->getParameter('tabs');
        if ($entityTypeId == Main::getTypeCrm()){
            $tabs[] = [
                'id' => 'contracts_tab_' . $entityTypeId . '_' . $entityId,
                'name' => Main::getNameTab(),
                'enabled' => true,
//            'html' => 'Содержимое вкладки '.Loc::getMessage('WITJA_CRMCUSTOMTAB_TAB_TITLE'),
                'loader' => [
                    'serviceUrl' => sprintf(
                        '/bitrix/components/witja.crmcustomtab/contracts.grid/lazyload.ajax.php?site=%s&%s',
                        \SITE_ID,
                        \bitrix_sessid_get(),
                    ),
                    'componentData' => [
                        'template' => '',
                        'params' => [
                            'ORM' => ContractsTable::class,
                        ],
                    ],
                ],
            ];
        }


        return new EventResult(EventResult::SUCCESS, ['tabs' => $tabs,]);
    }
}
