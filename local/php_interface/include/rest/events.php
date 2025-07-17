<?php
namespace Otus\Rest;

use Bitrix\Main\EventManager;
use Bitrix\Rest\RestException;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$eventManager = EventManager::getInstance();

$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);


class Events
{
    public static function OnRestServiceBuildDescriptionHandler()
    {
        Loc::getMessage('REST_SCOPE_OTUS_ORIGINALCONTACTSDATA');

        return [
            'otus.originalcontactsdata' => [
                'otus.originalcontactsdata.add' => [__CLASS__, 'add'],
                'otus.originalcontactsdata.list' => [__CLASS__, 'getList'],
                'otus.originalcontactsdata.update' => [__CLASS__, 'update'],
                'otus.originalcontactsdata.delete' => [__CLASS__, 'delete'],
            ]
        ];

    }

    public static function add ($arParams, $navStart, \CRestServer $server)
    {

        $originDataStoreResult = OriginalContactsDataTable::add($arParams);
        if ($originDataStoreResult->isSuccess())
        {
            return $originDataStoreResult->getId();
        }
        else
        {
            throw new RestException(json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }
    }

}
