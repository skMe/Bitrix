<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class sk_ibelmcntd7 extends CModule {

    public function __construct() {
        if (is_file(__DIR__.'/version.php')){
            include_once(__DIR__.'/version.php');
            $this->MODULE_ID           = get_class($this);
            $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
            $this->MODULE_NAME         = Loc::getMessage('IBELMCNT_NAME');
            $this->MODULE_DESCRIPTION  = Loc::getMessage('IBELMCNT_DESCRIPTION');
        } else {
            CAdminMessage::ShowMessage(
                Loc::getMessage('IBELMCNT_FILE_NOT_FOUND').' version.php'
            );
        }
    }
    
    public function DoInstall() {

        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            $this->InstallFiles();
            ModuleManager::registerModule($this->MODULE_ID);
        } else {
            CAdminMessage::ShowMessage(
                Loc::getMessage('IBELMCNT_INSTALL_ERROR')
            );
            return;
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('IBELMCNT_INSTALL_TITLE').' «'.Loc::getMessage('IBELMCNT_NAME').'»',
            __DIR__.'/step.php'
        );
    }
    
    public function InstallFiles() {
        CopyDirFiles(
            __DIR__.'/assets/components',
            Application::getDocumentRoot().'/local/components/',
            true,
            true
        );
        CopyDirFiles(
            __DIR__.'/assets/pages',
            Application::getDocumentRoot().'/'.$this->MODULE_ID.'/',
            true,
            true
        );
    }

    public function DoUninstall() {

        global $APPLICATION;

        $this->UnInstallFiles();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('IBELMCNT_UNINSTALL_TITLE').' «'.Loc::getMessage('IBELMCNT_NAME').'»',
            __DIR__.'/unstep.php'
        );

    }

    public function UnInstallFiles() {
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/local/components/sk/iblock.elements.count.d7/'
        );
        DeleteDirFiles(
            __DIR__.'/assets/pages',
            Application::getDocumentRoot().'/'.$this->MODULE_ID.'/'
        );
        Directory::deleteDirectory(
            Application::getDocumentRoot().'/'.$this->MODULE_ID.'/'
        );
        Option::delete($this->MODULE_ID);
    }

}