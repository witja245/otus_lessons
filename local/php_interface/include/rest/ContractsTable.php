<?php
namespace Otus\Rest;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

/**
 * Class ContractsTable
 *
 * Fields:
 * <ul>
 * <li> contract_id int mandatory
 * <li> contract_number string(20) mandatory
 * <li> client_name string(100) mandatory
 * <li> client_contact string(100) optional
 * <li> contract_date date mandatory
 * <li> start_date date optional
 * <li> end_date date optional
 * <li> amount double optional
 * <li> currency string(3) optional default 'RUB'
 * <li> status string(20) optional default 'Активный'
 * <li> description text optional
 * </ul>
 *
 * @package Bitrix\Contracts
 **/

class ContractsTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'otus_contracts';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'contract_id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CONTRACT_ID_FIELD'),
                    'size' => 8,
                ]
            ),
            new StringField(
                'contract_number',
                [
                    'required' => true,
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 20),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CONTRACT_NUMBER_FIELD'),
                ]
            ),
            new StringField(
                'client_name',
                [
                    'required' => true,
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 100),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CLIENT_NAME_FIELD'),
                ]
            ),
            new StringField(
                'client_contact',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 100),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CLIENT_CONTACT_FIELD'),
                ]
            ),
            new DateField(
                'contract_date',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CONTRACT_DATE_FIELD'),
                ]
            ),
            new DateField(
                'start_date',
                [
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_START_DATE_FIELD'),
                ]
            ),
            new DateField(
                'end_date',
                [
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_END_DATE_FIELD'),
                ]
            ),
            new FloatField(
                'amount',
                [
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_AMOUNT_FIELD'),
                ]
            ),
            new StringField(
                'currency',
                [
                    'default' => 'RUB',
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 3),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CURRENCY_FIELD'),
                ]
            ),
            new StringField(
                'status',
                [
                    'default' => 'Активный',
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 20),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_STATUS_FIELD'),
                ]
            ),
            new TextField(
                'description',
                [
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_DESCRIPTION_FIELD'),
                ]
            ),
        ];
    }
}