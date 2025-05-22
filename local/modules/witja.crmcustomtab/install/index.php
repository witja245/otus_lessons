<?php
IncludeModuleLangFile(__FILE__);

// пространство имен для подключений ланговых файлов
use Bitrix\Main\Localization\Loc;

// пространство имен для управления (регистрации/удалении) модуля в системе/базе
use Bitrix\Main\ModuleManager;

// пространство имен для работы с параметрами модулей хранимых в базе данных
use Bitrix\Main\Config\Option;

// пространство имен с абстрактным классом для любых приложений, любой конкретный класс приложения является наследником этого абстрактного класса
use Bitrix\Main\Application;

// пространство имен для работы c ORM
use \Bitrix\Main\Entity\Base;

// пространство имен для автозагрузки модулей
use \Bitrix\Main\Loader;

// пространство имен для событий
use \Bitrix\Main\EventManager;

use Bitrix\Main\IO\Directory;
use Bitrix\Main\SystemException;
use Bitrix\Main\IO\InvalidPathException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\LoaderException;
Loc::loadMessages(__FILE__);

if (class_exists("witja.crmcustomtab")) return;

class witja_crmcustomtab extends CModule
{
    /**
     * @var string
     */
    public $MODULE_ID = "witja.crmcustomtab";

    /**
     * @var string
     */
    protected $MODULE_CODE;

    /**
     * @var string
     */
    public $MODULE_VERSION;

    /**
     * @var string
     */
    public $MODULE_VERSION_DATE;

    /**
     * @var string
     */
    public $MODULE_NAME;

    /**
     * @var string
     */
    public $MODULE_DESCRIPTION;

    /**
     * @var string
     */
    public $PARTNER_NAME;

    function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__ . "/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = Loc::getMessage("WITJA_CUSTOMTAB_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("WITJA_CUSTOMTAB_MODULE_DESCRIPTION");

        $this->PARTNER_NAME = Loc::getMessage("WITJA_CUSTOMTAB_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("WITJA_CUSTOMTAB_PARTNER_URL");
    }

    function DoInstall()
    {
        // получаем контекст и из него запросы
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        // глобальная переменная с обстрактным классом
        global $APPLICATION;
        // проверяем какой сейчас шаг, если он не существует или меньше 2, то выводим первый шаг установки
        if ($request["step"] < 2) {
            // подключаем скрипт с административным прологом и эпилогом
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INSTALL_TITLE_STEP_1'),
                __DIR__ . '/instalInfo-step1.php'
            );
        }
        // проверяем какой сейчас шаг, усли 2, производим установку
        if ($request["step"] == 2) {
            // регистрируем модуль в системе
            ModuleManager::RegisterModule("witja.crmcustomtab");
            // создаем таблицы баз данных, необходимые для работы модуля
            $this->InstallDB();
            // регистрируем обработчики событий
            $this->InstallEvents();
            // копируем файлы, необходимые для работы модуля
            $this->InstallFiles();
            // устанавливаем агента
//            $this->InstallAgents();
            // проверяим ответ формы введеный пользователем на первом шаге
            if ($request["add_data"] == "Y") {
                // создаем первую и единственную запись в БД

            }
            // подключаем скрипт с административным прологом и эпилогом
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INSTALL_TITLE_STEP_2'),
                __DIR__ . '/instalInfo-step2.php'
            );
        }
        // для успешного завершения, метод должен вернуть true
        return true;
    }

    function DoUninstall()
    {

        // получаем контекст и из него запросы
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        // глобальная переменная с обстрактным классом
        global $APPLICATION;
        // проверяем какой сейчас шаг, если он не существует или меньше 2, то выводим первый шаг удаления
        if ($request["step"] < 2) {
            // подключаем скрипт с административным прологом и эпилогом
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DEINSTALL_TITLE_1'),
                __DIR__ . '/deInstalInfo-step1.php'
            );
        }
        // проверяем какой сейчас шаг, усли 2, производим удаление
        if ($request["step"] == 2) {
            // удаляем таблицы баз данных, необходимые для работы модуля
            //$this->UnInstallDB();
            // проверяим ответ формы введеный пользователем на первом шаге
            if ($request["save_data"] == "Y") {
                // удаляем таблицы баз данных, необходимые для работы модуля
                $this->UnInstallDB();
            }
            // удаляем обработчики событий
            $this->UnInstallEvents();
            // удаляем файлы, необходимые для работы модуля
            $this->UnInstallFiles();
            // удаляем агента
//            $this->unInstallAgents();
            // удаляем регистрацию модуля в системе
            ModuleManager::UnRegisterModule("witja.crmcustomtab");
            // подключаем скрипт с административным прологом и эпилогом
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DEINSTALL_TITLE_2'),
                __DIR__ . '/deInstalInfo-step2.php'
            );
        }
        // для успешного завершения, метод должен вернуть true
        return true;
    }

    /**
     * @return bool|void
     */
    public function InstallFiles()
    {
        $component_path = $this->getPath() . '/install/components';

        if (Directory::isDirectoryExists($component_path)) {
            CopyDirFiles($component_path, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components', true, true);
        } else {
            throw new InvalidPathException($component_path);
        }

        return true;
    }

    public function InstallEvents()
    {
        $eventManager = EventManager::getInstance();

        $eventManager->registerEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Witja\\Crmcustomtab\\Crm\\Handlers',
            'updateContactsTabs'
        );

    }
    public function UnInstallEvents()
    {

        $eventManager = EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Witja\\Crmcustomtab\\Crm\\Handlers',
            'updateTabs'
        );
    }
    public function InstallAgents()
    {

        return true;
    }

    /**
     * @return bool|void
     */
    public function UnInstallFiles()
    {
        $component_path = $this->getPath() . '/install/components';

        if (Directory::isDirectoryExists($component_path)) {
            $installed_components = new \DirectoryIterator($component_path);
            foreach ($installed_components as $component) {
                if ($component->isDir() && !$component->isDot()) {
                    $target_path = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $component->getFilename();
                    if (Directory::isDirectoryExists($target_path)) {
                        Directory::deleteDirectory($target_path);
                    }
                }
            }
        } else {
            throw new InvalidPathException($component_path);
        }
    }

    public function unInstallAgents()
    {

        return true;
    }

    function InstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/witja.crmcustomtab/install/db/install.sql");
        if (!$this->errors) {

            return true;
        } else
            return $this->errors;

    }

    // метод для удаления таблицы баз данных
    function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/local/modules/witja.crmcustomtab/install/db/uninstall.sql");
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;
    }

    public function getPath($notDocumentRoot = false): string
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        } else {
            return dirname(__DIR__);
        }
    }
}
