<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init(array("jquery"));
global $APPLICATION;
$APPLICATION->SetAdditionalCss($templateFolder."/css/slick.min.css");
$APPLICATION->AddHeadScript($templateFolder."/js/slick.min.js");
?>
