<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypes = CIBlockParameters::GetIBlockTypes();

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

$arSections=array("" => GetMessage("SK_SECTION_ID_DEF"));
$arFilter = array("SITE_ID"=>$_REQUEST["site"], "IBLOCK_ID" => ($arCurrentValues["IBLOCK_ID"] == "" ? 999 : $arCurrentValues["IBLOCK_ID"]));
$arSec = CIBlockSection::GetList(Array('LEFT_MARGIN'=>'ASC'), $arFilter, false, array("ID", "DEPTH_LEVEL", "NAME"));
while($arRes = $arSec->Fetch())
	$arSections[$arRes['ID'].' '] = str_repeat("- ", $arRes['DEPTH_LEVEL'] - 1)." [".$arRes["ID"]."] ".$arRes['NAME'];

$arElements=array();
$arFilter = array("IBLOCK_ID" => ($arCurrentValues["IBLOCK_ID"] == "" ? 999 : $arCurrentValues["IBLOCK_ID"]));
if ($arCurrentValues["SECTION_ID"]) $arFilter["SECTION_ID"] = $arCurrentValues["SECTION_ID"];
$arElm = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, false, array("ID", "NAME"));
while($arRes = $arElm->Fetch())
	$arElements[$arRes['ID']] = "[".$arRes["ID"]."] ".$arRes['NAME'];

$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SK_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypes,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SK_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"SECTION_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SK_SECTION_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arSections,
			"DEFAULT" => '',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SK_ELEMENT_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arElements,
			"DEFAULT" => '',
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
	)
);


?>