<?php
namespace Models;
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\DateField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\TextField,
    Bitrix\Main\ORM\Fields\DatetimeField,
    Bitrix\Main\ORM\Fields\FloatField,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator,
    Bitrix\Main\ORM\Fields\Validator\Base,
    Bitrix\Main\ORM\Fields\Validators\RegExpValidator,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Fields\Relations\OneToMany,
    Bitrix\Main\ORM\Fields\Relations\ManyToMany,
    Bitrix\Main\Entity\Query\Join;

use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Entity\EntityError;


use \Bitrix\Crm;
/**
 * Class ContractsTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> CONTACT_ID int mandatory
 * <li> NAME string(255) mandatory
 * <li> DATE_CREATE datetime mandatory
 * <li> DATE_MODIFY datetime mandatory
 * <li> CREATED_BY int mandatory
 * <li> MODIFIED_BY int mandatory
 * <li> UF_SUMMA double optional default 0.00
 * <li> UF_DATE_SIGN date optional
 * <li> UF_NUMBER string(50) optional
 * <li> UF_STATUS string(50) optional default 'активный'
 * </ul>
 *
 * @package Bitrix\Crm
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
        return 'b_crm_contracts';
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
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'CONTACT_ID',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CONTACT_ID_FIELD'),
                ]
            ),
            new StringField(
                'NAME',
                [
                    'required' => true,
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 255),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_NAME_FIELD'),
                ]
            ),
            new DatetimeField(
                'DATE_CREATE',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_DATE_CREATE_FIELD'),
                ]
            ),
            new DatetimeField(
                'DATE_MODIFY',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_DATE_MODIFY_FIELD'),
                ]
            ),
            new IntegerField(
                'CREATED_BY',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_CREATED_BY_FIELD'),
                ]
            ),
            new IntegerField(
                'MODIFIED_BY',
                [
                    'required' => true,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_MODIFIED_BY_FIELD'),
                ]
            ),
            new FloatField(
                'UF_SUMMA',
                [
                    'default' => 0.00,
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_UF_SUMMA_FIELD'),
                ]
            ),
            new DateField(
                'UF_DATE_SIGN',
                [
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_UF_DATE_SIGN_FIELD'),
                ]
            ),
            new StringField(
                'UF_NUMBER',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_UF_NUMBER_FIELD'),
                ]
            ),
            new StringField(
                'UF_STATUS',
                [
                    'default' => 'активный',
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('CONTRACTS_ENTITY_UF_STATUS_FIELD'),
                ]
            ),
            (new Reference('CONTACT', Crm\ContactTable::class,
                Join::on('this.CONTACT_ID', 'ref.ID')))
                ->configureJoinType('inner'),

        ];
    }
}