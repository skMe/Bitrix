<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/fdump.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/fdump.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/usertypefield.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/usertypefield.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/delkernelcssjs.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/delkernelcssjs.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/emaillogin.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/emaillogin.php");

//##### 404 #####
AddEventHandler("main", "OnEpilog", "Redirect404");
function Redirect404() {
	if(!defined('ADMIN_SECTION')
		&& defined("ERROR_404")
		&& ERROR_404 == 'Y'
//		&& defined("PATH_TO_404") 
//		&& file_exists($_SERVER["DOCUMENT_ROOT"].PATH_TO_404) 
	)
	{
		//LocalRedirect("/404.php", "404 Not Found");
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		CHTTP::SetStatus("404 Not Found");
		include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
		include($_SERVER["DOCUMENT_ROOT"]."/404.php");
		include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");
	}
}
