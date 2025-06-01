<?php
declare(strict_types=1);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
use Bitrix\Crm\CompanyTable;
use Bitrix\Main\Entity\ReferenceField;
$arSelect = ["ID", "NAME", "IBLOCK_ID"];
$arFilter = ["IBLOCK_ID"=>(int)21, "ID"=> (int)83];
$res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
$ob = $res->GetNextElement();
if ($ob)
{
    $fields = $ob->GetFields(); // указанные в $arSelect поля
    pr($fields);
    $properties = $ob->GetProperties();
    pr($properties);
}
die();
$entityResult = \CCrmCompany::GetListEx(
    [
        'SOURCE_ID' => 'DESC'
    ],
    [
        "ID" => 83
    ],
    false,
    false,
    [
        '*'
    ]
);

while( $entity = $entityResult->fetch() )
{
    /**
     * [ 'ID' => ..., 'TITLE' => ... ]
     * @var array
     */
    pr($entity);
}













?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');