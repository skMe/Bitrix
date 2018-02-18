<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$sid = '';
if ($arResult["SECTION"]) {
  $n = count($arResult["SECTION"]["PATH"]) - 1;
  $sid = $arResult["SECTION"]["PATH"][$n]["ID"];
}

$arResult["SECTIONS"] = array();

$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arParams["PARENT_SECTION"], "ACTIVE" => "Y");
$arSel = array("ID", "NAME", "DESCRIPTION", "PICTURE", "SECTION_PAGE_URL");
$res = CIBlockSection::GetList(array("SORT"=>"ASC"), $arFilter, false, $arSel);
while ($ar_res = $res->GetNext()) {
	$arButtons = CIBlock::GetPanelButtons($ar_res["IBLOCK_ID"], 0, $ar_res["ID"], array("SESSID"=>false));
	$ar_res["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
	$ar_res["DELETE_LINK"] = $arButtons["edit"]["delete_section"]["ACTION_URL"];
	$ar_res["PICTURE"] = CFile::GetFileArray($ar_res["PICTURE"]);
	$ar_res["PICTURE"]["THUMB"] = CFile::ResizeImageGet($ar_res["PICTURE"], array("width"=>150, "height"=>150), BX_RESIZE_IMAGE_EXACT)["src"];
	$arItems[] = $ar_res;
}
$arResult["SECTIONS"] = $arItems;

foreach ($arResult["ITEMS"] as $k => $arItem) if ($arItem["IBLOCK_SECTION_ID"] != $sid) unset($arResult["ITEMS"][$k]);

//dmp($arItems);

?>