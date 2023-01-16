<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
if(!CModule::IncludeModule("iblock"))
	return;

$arParams["CACHE_TIME"] = IntVal($arParams["CACHE_TIME"]);
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if($arParams["IBLOCK_TYPE"] == '')
	$arParams["IBLOCK_TYPE"] = "news";

$arParams["IBLOCK_ID"] = is_numeric($arParams["IBLOCK_ID"]) ? intval($arParams["IBLOCK_ID"]) : 0;

$arParams["ELEMENT_ID"] = is_numeric($arParams["ELEMENT_ID"]) ? intval($arParams["ELEMENT_ID"]) : 0;

if($arParams["SECTION_ID"]) $arParams["SECTION_ID"] = is_numeric($arParams["SECTION_ID"]) ? intval($arParams["SECTION_ID"]) : "";

$arResult["REQUEST"] = array("IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arParams["SECTION_ID"], "ELEMENT_ID" => $arParams["ELEMENT_ID"]);

if ($this->StartResultCache()) {
	$arFilter = array("IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arParams["ELEMENT_ID"]);
	if ($arParams["SECTION_ID"]) $arFilter["SECTION_ID"] = $arParams["SECTION_ID"];
	$arSelect = array("*","PROPERTY_*");
	$arElm = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, false, $arSelect);
	if ($arRes = $arElm->GetNextElement()) {
		$arResult = $arRes->GetFields();
		if ($arResult["PREVIEW_PICTURE"]) $arResult["PREVIEW_PICTURE"] = CFile::GetFileArray($arResult["PREVIEW_PICTURE"]);
		if ($arResult["DETAIL_PICTURE"]) $arResult["DETAIL_PICTURE"] = CFile::GetFileArray($arResult["DETAIL_PICTURE"]);
		$arResult["PROPERTIES"] = $arRes->GetProperties();
	}

		$resultCacheKeys = array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"IBLOCK_SECTION_ID",
			"LIST_PAGE_URL", "~LIST_PAGE_URL",
			"TIMESTAMP_X",
		);

	$this->setResultCacheKeys($resultCacheKeys);
	$this->IncludeComponentTemplate();
}

if(isset($arResult["ID"])) {
	$arTitleOptions = null;
	if(CModule::includeModule("iblock")) {
		CIBlockElement::CounterInc($arResult["ID"]);

		if($USER->IsAuthorized()) {
			if($APPLICATION->GetShowIncludeAreas()) {
				$arReturnUrl = array(
					"add_element" => CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "DETAIL_PAGE_URL"),
					"delete_element" => (
						empty($arResult["SECTION_URL"])?
						$arResult["LIST_PAGE_URL"]:
						$arResult["SECTION_URL"]
					),
				);

				$arButtons = CIBlock::GetPanelButtons(
					$arResult["IBLOCK_ID"],
					$arResult["ID"],
					$arResult["IBLOCK_SECTION_ID"],
					Array(
						"RETURN_URL" => $arReturnUrl,
						"SECTION_BUTTONS" => false,
					)
				);

				if($APPLICATION->GetShowIncludeAreas())
					$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

				if($arParams["SET_TITLE"] || isset($arResult[$arParams["BROWSER_TITLE"]])) {
					$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => $arButtons["submenu"]["edit_element"]["ACTION"],
						'PUBLIC_EDIT_LINK' => $arButtons["edit"]["edit_element"]["ACTION"],
						'COMPONENT_NAME' => $this->getName(),
					);
				}
			}
		}
	}
	return $arResult["ID"];
} else {
	return 0;
}
