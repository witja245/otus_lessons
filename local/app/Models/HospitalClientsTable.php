<?php
namespace Models;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator,
    Bitrix\Main\ORM\Fields\Validators\RegExpValidator,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Fields\Relations\OneToMany,
    Bitrix\Main\Entity\Query\Join;


/**
 * Class ClientsTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> first_name string(50) optional
 * <li> last_name string(50) optional
 * <li> age int optional
 * <li> doctor_id int optional
 * <li> procedure_id int optional
 * <li> contact_id int optional
 * </ul>
 *
 * @package Bitrix\Clients
 **/

class HospitalClientsTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'hospital_clients';
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
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('CLIENTS_ENTITY_ID_FIELD'),
                ]
            ),
            new StringField(
                'first_name',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('CLIENTS_ENTITY_FIRST_NAME_FIELD'),
                ]
            ),
            new StringField(
                'last_name',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('CLIENTS_ENTITY_LAST_NAME_FIELD'),
                ]
            ),
            new IntegerField(
                'age',
                [
                    'title' => Loc::getMessage('CLIENTS_ENTITY_AGE_FIELD'),
                ]
            ),
            new IntegerField(
                'doctor_id',
                [
                    'title' => Loc::getMessage('CLIENTS_ENTITY_DOCTOR_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'procedure_id',
                [
                    'title' => Loc::getMessage('CLIENTS_ENTITY_PROCEDURE_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'contact_id',
                [
                    'title' => Loc::getMessage('CLIENTS_ENTITY_CONTACT_ID_FIELD'),
                ]
            ),
            // виртуальное поле CONTACT которое получает запись из таблицы контактов
            // где ID равен значению contact_id таблицы hospital_clients
            (new Reference(
                'CONTACT',
                \Bitrix\CRM\ContactTable::class,
                Join::on('this.contact_id', 'ref.ID'))
            )->configureJoinType('inner'),
            // виртуальное поле DOCTOR которое получает запись из таблицы контактов
            // где ID равен значению doctor_id таблицы hospital_clients
            (new Reference('DOCTOR', \Bitrix\Iblock\Elements\ElementDoctorsTable::class,
                Join::on('this.doctor_id', 'ref.ID')))
                ->configureJoinType('inner'),
        ];
    }

    /**
     * Returns validators for first_name field.
     *
     * @return array
     */
    public static function validateFirstName()
    {
        return [
            new LengthValidator(null, 50),
            // new RegExpValidator("/^([а-яё]+|[a-z]+)$/i")
        ];
    }

    /**
     * Returns validators for last_name field.
     *
     * @return array
     */
    public static function validateLastName()
    {
        return [
            new LengthValidator(null, 50),
            // new RegExpValidator("/^([а-яё]+|[a-z]+)$/i")
        ];
    }


    /**
     * Returns validators for age field.
     *
     * @return array
     */

    public static function validateAge(){
        return [
            new LengthValidator(null, null),
        ];
    }

}