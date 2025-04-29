<?php
namespace Models;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\DateField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\TextField,
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

use Models\PublisherTable as Publisher;
use Models\AuthorTable as Author;
use Models\WikiprofileTable as Wikiprofile;

/**
 * Class Table
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> name string(50) optional
 * <li> text text optional
 * <li> articul string(50) optional
 * <li> author_id int optional
 * <li> manufacture_id int optional
 * <li> price int optional
 * </ul>
 *
 * @package Bitrix\
 **/

class ComputerTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'computers';
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
                    'title' => Loc::getMessage('_ENTITY_ID_FIELD'),
                ]
            ),
            new StringField(
                'name',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('_ENTITY_NAME_FIELD'),
                ]
            ),
            new TextField(
                'text',
                [
                    'title' => Loc::getMessage('_ENTITY_TEXT_FIELD'),
                ]
            ),
            new StringField(
                'articul',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                    'title' => Loc::getMessage('_ENTITY_ARTICUL_FIELD'),
                ]
            ),
            new IntegerField(
                'shop_id',
                [
                    'title' => Loc::getMessage('_ENTITY_SHOP_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'manufacture_id',
                [
                    'title' => Loc::getMessage('_ENTITY_MANUFACTURE_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'price',
                [
                    'title' => Loc::getMessage('_ENTITY_PRICE_FIELD'),
                ]
            ),
            (new Reference('SHOP', \Bitrix\Iblock\Elements\ElementShopTable::class,
                Join::on('this.shop_id', 'ref.ID')))
                ->configureJoinType('inner'),
            (new Reference('MANUFACTURE', \Bitrix\Iblock\Elements\ElementManufacturesTable::class,
                Join::on('this.manufacture_id', 'ref.ID')))
                ->configureJoinType('inner'),
        ];
    }
}