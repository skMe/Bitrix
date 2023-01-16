<?php
IncludeModuleLangFile(__FILE__);

class sk_platformcraft extends CModule {

	public function __construct() {
		if (is_file(__DIR__.'/version.php')){
			include_once(__DIR__.'/version.php');
			$this->MODULE_ID           = "sk_platformcraft";
			$this->MODULE_VERSION      = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
			$this->MODULE_NAME         = GetMessage('SKPC_NAME');
			$this->MODULE_DESCRIPTION  = GetMessage('SKPC_DESCRIPTION');
		} else {
			CAdminMessage::ShowMessage(GetMessage('SKPC_FILE_NOT_FOUND').' version.php');
		}
	}

	public function DoInstall() {
		global $APPLICATION;
		$this->InstallFiles();
		RegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(GetMessage('SKPC_INSTALL_TITLE').' «'.GetMessage('SKPC_NAME').'»', __DIR__.'/step.php');
	}

	public function InstallFiles() {
		CopyDirFiles(__DIR__.'/assets/components', $_SERVER['DOCUMENT_ROOT'].'/local/components/', true, true);
	}

	public function DoUninstall() {
		global $APPLICATION;
		$this->UnInstallFiles();
		UnRegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(GetMessage('SKPC_UNINSTALL_TITLE').' «'.GetMessage('SKPC_NAME').'»', __DIR__.'/unstep.php');
	}

	public function UnInstallFiles() {
		DeleteDirFilesEx('/local/components/sk/platformcraft');
		COption::RemoveOption($this->MODULE_ID);
	}

}