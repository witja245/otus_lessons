<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/services/telephony/ivr.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");

$APPLICATION->SetTitle(GetMessage("VI_PAGE_IVR_TITLE"));
?>

<?$APPLICATION->IncludeComponent("bitrix:voximplant.ivr..default", "", array());?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
