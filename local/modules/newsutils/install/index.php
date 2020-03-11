<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class newsutils extends CModule
{
	var $MODULE_ID = "newsutils";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = 'News Utils';
		$this->MODULE_DESCRIPTION = 'Make some functions for component news';
	}


	function InstallDB($install_wizard = true)
	{
		RegisterModule("newsutils");
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		UnRegisterModule("newsutils");
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		return true;
	}

	function UnInstallFiles()
	{
		return true;
	}

	function DoInstall()
	{
		$this->InstallFiles();
		$this->InstallDB(false);
	}

	function DoUninstall()
	{

	}
}
?>