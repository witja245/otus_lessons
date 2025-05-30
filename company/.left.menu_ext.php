<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Intranet\Settings\Tools\ToolsManager;
use Bitrix\Intranet\Site\Sections\TimemanSection;
use Bitrix\Landing\Rights;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/intranet/public/company/.left.menu.php');
$GLOBALS['APPLICATION']->setPageProperty('topMenuSectionDir', '/company/');
$menuItems = [];

if (ToolsManager::getInstance()->checkAvailabilityByMenuId('menu_employee'))
{
	$menuItems[] = [
		Loc::getMessage('COMPANY_MENU_EMPLOYEE_LIST'),
		SITE_DIR . 'company/',
		[],
		[
			'menu_item_id' => 'menu_employee',
		],
		'',
	];
}

if (ToolsManager::getInstance()->checkAvailabilityByMenuId('menu_company'))
{
	$menuItems[] = [
		Loc::getMessage('COMPANY_MENU_STRUCTURE'),
		SITE_DIR . 'hr/structure/',
		[],
		[
			'menu_item_id' => 'menu_company',
		],
		'',
	];
}

if (Loader::includeModule('intranet') && TimemanSection::isAvailable())
{
	$menuItems[] = TimemanSection::getRootMenuItem();
}

$landingIncluded = Loader::includeModule('landing');

if (
	$landingIncluded
	&& Rights::hasAdditionalRight(Rights::ADDITIONAL_RIGHTS['menu24'], 'knowledge')
	&& ToolsManager::getInstance()->checkAvailabilityByMenuId('menu_knowledge')
)
{
	$menuItems[] = [
		Loc::getMessage('COMPANY_MENU_KNOWLEDGE_BASE'),
		SITE_DIR . 'kb/',
		[],
		[
			'menu_item_id' => 'menu_knowledge',
			'my_tools_section' => true,
		],
		'',
	];
}

if (
	\Bitrix\Main\ModuleManager::isModuleInstalled('im')
	&& ToolsManager::getInstance()->checkAvailabilityByMenuId('menu_conference')
)
{
	$menuItems[] = [
		Loc::getMessage('COMPANY_MENU_CONFERENCES'),
		SITE_DIR . 'conference/',
		[],
		[
			'menu_item_id' => 'menu_conference',
		],
		''
	];
}

//merge with static items from left.menu
$ignoreLinks = [
	SITE_DIR . 'company/',
	SITE_DIR . 'hr/structure/',
	SITE_DIR . 'company/index.php',
];

foreach ($aMenuLinks as $item)
{
	if (!in_array($item[1], $ignoreLinks))
	{
		$menuItems[] = $item;
	}
}

$aMenuLinks = $menuItems;