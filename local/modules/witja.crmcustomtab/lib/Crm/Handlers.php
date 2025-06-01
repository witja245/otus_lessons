<?php
namespace Witja\Crmcustomtab\Crm;

use Witja\customtab\lib\Orm\ContractsTable;
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
        $tabs[] = [
            'id' => 'contacts_tab_' . $entityTypeId . '_' . $entityId,
            'name' => Loc::getMessage('WITJA_CRMCUSTOMTAB_TAB_TITLE'),
            'enabled' => true,
            'loader' => [
                'serviceUrl' => sprintf(
                    '/bitrix/components/witja.crmcustomtab/contacts.grid/lazyload.ajax.php?site=%s&%s',
                    \SITE_ID,
                    \bitrix_sessid_get(),
                ),
                'componentData' => [
                    'template' => '',
                    'params' => [
                        'ORM' => ContractsTable::class,
                        'DEAL_ID' => $entityId,
                    ],
                ],
            ],
        ];

        return new EventResult(EventResult::SUCCESS, ['tabs' => $tabs,]);
    }
}
