<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Witja\CrmCustomTab\lib\Orm\ContractsTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\Filter\Options as FilterOptions;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\UI\PageNavigation;

Loader::includeModule('witja.crmcustomtab');

class CCheckContractstTableSignator extends CBitrixComponent
{
    public function configureActions(): array
    {
        return [];
    }

    private function getElementActions(): array
    {
        return [];
    }

    private function getHeaders(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'sort' => 'ID',
                'default' => true,
            ],
            [
                'id' => 'NAME',
                'name' => Loc::getMessage('CONTRACT_GRID_CONTRACT_NAME_LABEL'),
                'sort' => 'NAME',
                'default' => true,
            ],
            [
                'id' => 'CONTACT_ID',
                'name' => Loc::getMessage('CONTRACT_GRID_CONTACT_ID_LABEL'),
                'sort' => 'CONTACT_ID',
                'default' => true,
            ],
            [
                'id' => 'UF_NUMBER',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_NUMBER_LABEL'),
                'sort' => 'UF_NUMBER',
                'default' => true,
            ],
            [
                'id' => 'UF_SUMMA',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_SUMMA_LABEL'),
                'sort' => 'UF_SUMMA',
                'default' => true,
            ],
            [
                'id' => 'UF_DATE_SIGN',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_DATE_SIGN_LABEL'),
                'default' => true,
            ],
            [
                'id' => 'UF_STATUS',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_STATUS_LABEL'),
                'sort' => 'UF_STATUS',
                'default' => true,
            ],
            [
                'id' => 'CREATED_BY',
                'name' => Loc::getMessage('CONTRACT_GRID_CREATED_BY_LABEL'),
                'sort' => 'CREATED_BY',
                'default' => true,
            ],
            [
                'id' => 'DATE_CREATE',
                'name' => Loc::getMessage('CONTRACT_GRID_DATE_CREATE_LABEL'),
                'sort' => 'DATE_CREATE',
                'default' => true,
            ],
        ];
    }

    public function executeComponent(): void
    {
        $this->prepareGridData();
        $this->includeComponentTemplate();
    }

    private function prepareGridData(): void
    {
        $this->arResult['HEADERS'] = $this->getHeaders();
        $this->arResult['FILTER_ID'] = 'CONTRACT_GRID';

        $gridOptions = new GridOptions($this->arResult['FILTER_ID']);

        $navParams = $gridOptions->getNavParams();

        $nav = new PageNavigation($this->arResult['FILTER_ID']);
        $nav->allowAllRecords(true)
            ->setPageSize($navParams['nPageSize'])
            ->initFromUri();

        $filterOption = new FilterOptions($this->arResult['FILTER_ID']);

        $filterData = $filterOption->getFilter([]);

        $filter = $this->prepareFilter($filterData);


        $sort = $gridOptions->getSorting([
            'sort' => [
                'ID' => 'DESC',
            ],
            'vars' => [
                'by' => 'by',
                'order' => 'order',
            ],
        ]);
        $countQuery = ContractsTable::query()
            ->setSelect(['ID'])
            ->setFilter($filter)
        ;
        $nav->setRecordCount($countQuery->queryCountTotal());
        $contracts = ContractsTable::getList([
            'filter' => $filter,
            'select' => [
                'ID',
                'NAME',
                'DATE_CREATE',
                'DATE_MODIFY',
                'UF_SUMMA',
                'UF_DATE_SIGN',
                'UF_NUMBER',
                'UF_STATUS',
                'CONTACT_ID',
                'CONTACT_LAST_NAME' => 'CONTACT.LAST_NAME',
                'CONTACT_NAME' => 'CONTACT.NAME',
                'CONTACT_SECOND_NAME' => 'CONTACT.SECOND_NAME',
                'CREATED_BY',
                'CREATED_BY_LAST_NAME' => 'CREATED_USER.LAST_NAME',
                'CREATED_BY_NAME' => 'CREATED_USER.NAME',
                'CREATED_BY_SECOND_NAME' => 'CREATED_USER.SECOND_NAME',
            ],
            'limit' => $nav->getLimit(),
            'offset' => $nav->getOffset(),
        ])->fetchAll();

        if (!empty($contracts)) {
            $this->arResult['GRID_LIST'] = $this->prepareGridList($contracts);
        } else {
            $this->arResult['GRID_LIST'] = [];
        }

        $this->arResult['NAV'] = $nav;
        $this->arResult['UI_FILTER'] = $this->getFilterFields();
    }

    private function prepareFilter(array $filterData): array
    {
        $filter = [];

        if (!empty($filterData['NAME'])) {
            $filter['%NAME'] = $filterData['NAME'];
        }

        if (!empty($filterData['CONTACT_ID_from'])) {
            $filter['>=CONTACT_ID'] = $filterData['CONTACT_ID_from'];
        }

        if (!empty($filterData['CONTACT_ID_to'])) {
            $filter['<=CONTACT_ID'] = $filterData['CONTACT_ID_to'];
        }

        if (!empty($filterData['UF_DATE_SIGN_from'])) {
            $filter['>=UF_DATE_SIGN'] = $filterData['UF_DATE_SIGN_from'];
        }

        if (!empty($filterData['UF_DATE_SIGN_to'])) {
            $filter['<=UF_DATE_SIGN'] = $filterData['UF_DATE_SIGN_to'];
        }

        return $filter;
    }

    private function prepareGridList($contracts)
    {
        $gridList = [];

        foreach ($contracts as $contract) {

            $gridList[] = [
                'data' => [
                    'ID' => $contract['ID'],
                    'NAME' => $contract['NAME'],
                    'CONTACT_ID' => '<a href="/crm/contact/details/'.$contract['CONTACT_ID'].'/">'.$contract['CONTACT_LAST_NAME'].' '.$contract['CONTACT_NAME'].' '.$contract['CONTACT_SECOND_NAME'].'</a>',
                    'UF_NUMBER' => $contract['UF_NUMBER'],
                    'UF_SUMMA' => $contract['UF_SUMMA'],
                    'UF_DATE_SIGN' => ConvertDateTime($contract['UF_DATE_SIGN'], "DD.MM.YYYY", "ru"),
                    'UF_STATUS' => $contract['UF_STATUS'],
                    'CREATED_BY' => '<a href="/company/personal/user/'.$contract['CREATED_BY'].'/">'.$contract['CREATED_BY_LAST_NAME'].' '.$contract['CREATED_BY_NAME'].' '.$contract['CREATED_BY_SECOND_NAME'].'</a>',
                    'DATE_CREATE' => ConvertDateTime($contract['DATE_CREATE'], "DD.MM.YYYY HH:MI:SS", "ru"),
                ],
                'actions' => $this->getElementActions(),
            ];
        }

        return $gridList;
    }

    private function getFilterFields(): array
    {
        return [
            [
                'id' => 'CONTACT_ID',
                'name' => Loc::getMessage('CONTRACT_GRID_CONTRACT_CONTACT_ID_LABEL'),
                'type' => 'number',
                'default' => true,
            ],
            [
                'id' => 'NAME',
                'name' => Loc::getMessage('CONTRACT_GRID_CONTRACT_NAME_LABEL'),
                'type' => 'string',
                'default' => true,
            ],
            [
                'id' => 'UF_NUMBER',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_NUMBER_LABEL'),
                'type' => 'string',
                'default' => true,
            ],
            [
                'id' => 'UF_DATE_SIGN',
                'name' => Loc::getMessage('CONTRACT_GRID_UF_DATE_SIGN_LABEL'),
                'type' => 'date',
                'default' => true,
            ],

        ];
    }

}