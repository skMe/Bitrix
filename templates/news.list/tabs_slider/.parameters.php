<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(CModule::IncludeModule("iblock")) {
	if(isset($arCurrentValues["IBLOCK_ID"]) && intval($arCurrentValues["IBLOCK_ID"])>0)
	{
		$arListSections = Array(''=>' -Не выбрано- ');
		$arFilter = Array(
			'IBLOCK_ID' => intval($arCurrentValues["IBLOCK_ID"]),
			'GLOBAL_ACTIVE'=>'Y',
			'IBLOCK_ACTIVE'=>'Y',
		);
		if(isset($arCurrentValues["IBLOCK_TYPE"]) && $arCurrentValues["IBLOCK_TYPE"]!='')
			$arFilter['IBLOCK_TYPE'] = $arCurrentValues["IBLOCK_TYPE"];

		$arSec = CIBlockSection::GetList(Array('LEFT_MARGIN'=>'ASC'), $arFilter, false, array("ID", "DEPTH_LEVEL", "NAME"));
		while($arRes = $arSec->Fetch())
			$arListSections[$arRes['ID']] = str_repeat("-", $arRes['DEPTH_LEVEL']).' '.$arRes['NAME'];

		$arTemplateParameters["PARENT_SECTION"] = Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_SECTION_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arListSections,
			"DEFAULT" => '', 
		);
	}
}
?>
