<?php
/**
 * @global  \CMain $APPLICATION
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/bizproc/processes/index.php");
$APPLICATION->SetTitle(GetMessage("PROCESSES_TITLE"));

if (
	\Bitrix\Main\Loader::includeModule('bizproc')
	&& class_exists(\Bitrix\Bizproc\Integration\Intranet\ToolsManager::class)
	&& !\Bitrix\Bizproc\Integration\Intranet\ToolsManager::getInstance()->isBizprocAvailable()
)
{
	echo \Bitrix\Bizproc\Integration\Intranet\ToolsManager::getInstance()->getBizprocUnavailableContent();
}
else
{
	$APPLICATION->IncludeComponent("bitrix:lists", ".default", array(
		"IBLOCK_TYPE_ID" => "bitrix_processes",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => SITE_DIR."bizproc/processes/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"SEF_URL_TEMPLATES" => array(
			"lists" => "",
			".default" => "#list_id#/view/#section_id#/",
			"list_sections" => "#list_id#/edit/#section_id#/",
			"list_edit" => "#list_id#/edit/",
			"list_fields" => "#list_id#/fields/",
			"list_field_edit" => "#list_id#/field/#field_id#/",
		)
	),
		false
	);
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
