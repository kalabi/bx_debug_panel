<?

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class custom_debugbar extends \CModule
{
    public $MODULE_ID = 'custom.debugbar';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_SORT;
    public $MODULE_MODE_EXEC = 'local';

    // пути
    public $PATH;
    public $PATH_ADMIN;
    public $PATH_INSTALL;
    public $PATH_INSTALL_DB;

    // пути в CMS
    public $BXPATH;
    public $BXPATH_ADMIN;

    public function __construct()
    {
        // информация о модуле и разработчике
        $this->MODULE_NAME = Loc::getMessage('CUSTOM_DEBUGBAR_INSTALL_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('CUSTOM_DEBUGBAR_INSTALL_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('CUSTOM_DEBUGBAR_INSTALL_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('CUSTOM_DEBUGBAR_INSTALL_MODULE_PARTNER_URI');

        // версия
        $arModuleVersion = array(
            'VERSION'      => '',
            'VERSION_DATE' => ''
        );
        include(__DIR__.'/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        // пути
        global $DBType;
        $this->PATH = \Bitrix\Main\Application::getDocumentRoot()."/$this->MODULE_MODE_EXEC/modules/$this->MODULE_ID";
        $this->PATH_ADMIN = "$this->PATH/admin";
        $this->PATH_INSTALL = "$this->PATH/install";
        $this->PATH_INSTALL_DB = "$this->PATH_INSTALL/db/$DBType";

        // пути в CMS битрикс
        $this->BXPATH = \Bitrix\Main\Application::getDocumentRoot()."/$this->MODULE_MODE_EXEC";
        $this->BXPATH_ADMIN = \Bitrix\Main\Application::getDocumentRoot()."/bitrix/admin";
    }

    public function InstallDB()
    {
        return true;
    }

    public function UnInstallDB()
    {
        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles($this->PATH.'/components/custom/dbb/', $this->BXPATH.'/components/custom/dbb/', true, true);

        return true;
    }

    public function UnInstallFiles()
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($this->BXPATH.'/components/custom/dbb/');

        return true;
    }

    public function InstallEvents()
    {
        return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function DoInstall()
    {
        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();

        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $this->UnInstallDB();
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
