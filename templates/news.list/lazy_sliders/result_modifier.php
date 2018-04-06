<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult["SEC_INFO"] = array();
if ($arResult["SECTION"]) {
	$n = count($arResult["SECTION"]["PATH"]) - 1;
	$arResult["SEC_INFO"]["IBLOCK_ID"] = $arResult["SECTION"]["PATH"][$n]["IBLOCK_ID"];
	$arResult["SEC_INFO"]["ID"] = $arResult["SECTION"]["PATH"][$n]["ID"];
	$arResult["SEC_INFO"]["NAME"] = $arResult["SECTION"]["PATH"][$n]["NAME"];
	$arResult["SEC_INFO"]["DESC"] = $arResult["SECTION"]["PATH"][$n]["DESCRIPTION"];
	$arResult["SEC_INFO"]["IMG"] = CFile::GetFileArray($arResult["SECTION"]["PATH"][$n]["DETAIL_PICTURE"]);
	$arButtons = CIBlock::GetPanelButtons($arResult["SECTION"]["PATH"][$n]["IBLOCK_ID"], 0, $arResult["SECTION"]["PATH"][$n]["ID"], array("SESSID"=>false));
	$arResult["SEC_INFO"]["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
}

foreach ($arResult["ITEMS"] as &$arItem) {
	if ($arItem["PROPERTIES"]["SLIDER_IMGS"]["VALUE"]) {
		foreach ($arItem["PROPERTIES"]["SLIDER_IMGS"]["VALUE"] as $k => $img) {
			$arItem["SLIDER_IMGS"][$k]["IMG"] = CFile::ResizeImageGet($img, array("width"=>580, "height"=>387), BX_RESIZE_IMAGE_EXACT)["src"];
			$arItem["SLIDER_IMGS"][$k]["DESC"] = $arItem["PROPERTIES"]["SLIDER_IMGS"]["DESCRIPTION"][$k];
		}
	}
}


?>