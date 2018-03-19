<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//dmp($templateFolder);
if ($arParams["IMG_LINK"])
{
	CJSCore::Init(array("jquery"));
	$APPLICATION->SetAdditionalCSS($templateFolder."/vendor/jquery.fancybox.min.css");
	$APPLICATION->AddHeadScript($templateFolder."/vendor/jquery.fancybox.min.js");
}
?>