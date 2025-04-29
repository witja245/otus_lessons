<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use KitFinance\Quick\Main as CKitFinanceQuick;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("KITFINANCE_MODULE_QUICK_TITLE"),
        "TITLE" => Loc::getMessage("KITFINANCE_MODULE_QUICK_TITLE_EXT"),
        "OPTIONS" => array(
            array(
                CKitFinanceQuick::$urlKey,
                Loc::getMessage("KITFINANCE_QUICK_URL_TITLE"),
                "",
                array("text", 30)
            ),
            array(
                CKitFinanceQuick::$portKey,
                Loc::getMessage("KITFINANCE_QUICK_PORT_TITLE"),
                "",
                array("text", 30)
            ),
            array(
                CKitFinanceQuick::$loginKey,
                Loc::getMessage("KITFINANCE_QUICK_LOGIN_TITLE"),
                "",
                array("text", 30)
            ),
            array(
                CKitFinanceQuick::$passKey,
                Loc::getMessage("KITFINANCE_QUICK_PASSWORD_TITLE"),
                "",
                array("password", 30)
            ),
            array(
                CKitFinanceQuick::$dbname,
                Loc::getMessage("KITFINANCE_QUICK_DB_TITLE"),
                "",
                array("text", 30)
            ),
        )
    ),
    array(
        "DIV" => "edit2",
        "TAB" => Loc::getMessage("KITFINANCE_MODULE_QUICK_TITLE_EDIT2"),
        "TITLE" => Loc::getMessage("KITFINANCE_MODULE_QUICK_TITLE_TEXT_EDIT2"),
        "OPTIONS" => array(
            "Настройка отправки xml для продакшн",
            array(
                CKitFinanceQuick::$sendfolder,
                Loc::getMessage("KITFINANCE_QUICK_PASSWORD_SEND_FOLDER"),
                "",
                array("text", 30)
            ),
            array(
                CKitFinanceQuick::$resultfolder,
                Loc::getMessage("KITFINANCE_QUICK_PASSWORD_RESULT_FOLDER"),
                "",
                array("text", 30)
            ),
            "Настройка отправки xml для тестового",
            array(
                CKitFinanceQuick::$sendfolderTest,
                Loc::getMessage("KITFINANCE_QUICK_PASSWORD_SEND_FOLDER"),
                "",
                array("text", 30)
            ),
            array(
                CKitFinanceQuick::$resultfolderTest,
                Loc::getMessage("KITFINANCE_QUICK_PASSWORD_RESULT_FOLDER"),
                "",
                array("text", 30)
            ),

        )
    ),
);

$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();
?>
    <form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>"
          method="post">

        <?
        foreach ($aTabs as $aTab) {

            if ($aTab["OPTIONS"]) {

                $tabControl->BeginNextTab();

                __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
            }
        }

        $tabControl->Buttons();
        ?>

        <input type="submit" name="apply" value="Применить" class="adm-btn-save"/>
        <input type="submit" name="default" value="По умолчанию"/>

        <?
        echo(bitrix_sessid_post());
        ?>

    </form>
<?php
$tabControl->End();
if ($request->isPost() && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) {

        foreach ($aTab["OPTIONS"] as $arOption) {

            if (!is_array($arOption)) {

                continue;
            }

            if ($arOption["note"]) {

                continue;
            }

            if ($request["apply"]) {

                $optionValue = $request->getPost($arOption[0]);

                if ($arOption[0] == "switch_on") {

                    if ($optionValue == "") {

                        $optionValue = "N";
                    }
                }

                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            } elseif ($request["default"]) {

                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . $module_id . "&lang=" . LANG);
}
?>