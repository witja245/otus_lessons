<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	'bitrix:ui.sidepanel.wrapper',
	'',
	[
		'POPUP_COMPONENT_NAME' => 'bitrix:main.field.config..default',
		'POPUP_COMPONENT_TEMPLATE_NAME' => '',
		'POPUP_COMPONENT_PARAMS' => [
			'detailUrl' => SITE_DIR.'configs/userfield.php',
		],
		"USE_PADDING" => false,
		"USE_UI_TOOLBAR" => "Y",
	]
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>