<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTitles = array();
foreach ($arResult["ITEMS"] as $key => $arItem) {
	$imgs = array();
	foreach ($arItem["PROPERTIES"]["SLIDER_IMGS"]["VALUE"] as $k => $img) {
		$arImg = CFile::GetFileArray($img);
		$arPrw = CFile::ResizeImageGet($img, array('width'=>600, 'height'=>440), BX_RESIZE_IMAGE_PROPORTIONAL,/*BX_RESIZE_IMAGE_EXACT*/ true);
		$imgs[$k] = array("SRC" => $arImg["SRC"], "NAME" => preg_replace("/\.\w+\b/", "", $arImg["FILE_NAME"]), "PREVIEW" => $arPrw["src"], "DESC" => $arImg["DESCRIPTION"], "WIDTH" => $arPrw["width"]);
	}
	$arResult["ITEMS"][$key]["IMAGES"] = $imgs;
	$arTitles[$key] = $arItem["NAME"];
}
$arResult["TITLES"] = $arTitles;
?>