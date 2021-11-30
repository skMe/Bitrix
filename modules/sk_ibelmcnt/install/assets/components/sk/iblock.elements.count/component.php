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
$module_id = "sk_ibelmcnt";

$arResult = array("ERRORS" => array(), "IBLOCK_ID" => 0, "IBLOCK_NAME" => 0, "ELEMENTS" => array(), "ELEMENTS_COUNT" => 0);
$iblock_id = COption::GetOptionInt($module_id, "iblock_id", 0);
$arResult["IBLOCK_ID"] = $iblock_id;
if (!is_numeric($iblock_id)) $arResult["ERRORS"][] = "Неверный формат ID Инфоблока";
if ($iblock_id == 0) $arResult["ERRORS"][] = "Не настроен ID Инфоблока";
if (!$arResult["ERRORS"]) {
	$dbItems = CIBlockElement::GetList(false, array('IBLOCK_ID' => intval($arResult["IBLOCK_ID"])), false, false, array("ID", "IBLOCK_ID", "NAME"));
	while ($elm = $dbItems->GetNext()) { $arResult["ELEMENTS"][] = $elm; }
	$arResult["ELEMENTS_COUNT"] = count($arResult["ELEMENTS"]);
	$arResult["IBLOCK_NAME"] = CIBlock::GetArrayByID($iblock_id, "NAME");
}

$this->IncludeComponentTemplate();
