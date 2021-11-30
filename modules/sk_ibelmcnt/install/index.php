<?php
IncludeModuleLangFile(__FILE__);

class sk_ibelmcnt extends CModule {

	public function __construct() {
		if (is_file(__DIR__.'/version.php')){
			include_once(__DIR__.'/version.php');
			$this->MODULE_ID           = get_class($this);
			$this->MODULE_VERSION      = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
			$this->MODULE_NAME         = GetMessage('IBELMCNT_NAME');
			$this->MODULE_DESCRIPTION  = GetMessage('IBELMCNT_DESCRIPTION');
		} else {
			CAdminMessage::ShowMessage(GetMessage('IBELMCNT_FILE_NOT_FOUND').' version.php');
		}
	}

	public function DoInstall() {
		global $APPLICATION;
		$this->InstallFiles();
		RegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(GetMessage('IBELMCNT_INSTALL_TITLE').' «'.GetMessage('IBELMCNT_NAME').'»', __DIR__.'/step.php');
	}

	public function InstallFiles() {
		CopyDirFiles(__DIR__.'/assets/components', $_SERVER['DOCUMENT_ROOT'].'/local/components/', true, true);
		CopyDirFiles(__DIR__.'/assets/pages', $_SERVER['DOCUMENT_ROOT'].'/'.$this->MODULE_ID.'/', true, true);
	}

	public function DoUninstall() {
		global $APPLICATION;
		$this->UnInstallFiles();
		UnRegisterModule($this->MODULE_ID);
		$APPLICATION->IncludeAdminFile(GetMessage('IBELMCNT_UNINSTALL_TITLE').' «'.GetMessage('IBELMCNT_NAME').'»', __DIR__.'/unstep.php');
	}

	public function UnInstallFiles() {
		DeleteDirFilesEx('/local/components/sk/iblock.elements.count');
		DeleteDirFilesEx('/'.$this->MODULE_ID);
		COption::RemoveOption($this->MODULE_ID);
	}

}