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
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
Loader::includeModule('iblock');
$module_id = "sk_ibelmcntd7";

$arResult = array("ERRORS" => array(), "IBLOCK_ID" => 0, "IBLOCK_NAME" => 0, "ELEMENTS" => array(), "ELEMENTS_COUNT" => 0);
$iblock_id = Option::get($module_id, "iblock_id", 0);
$arResult["IBLOCK_ID"] = $iblock_id;
if (!is_numeric($iblock_id)) $arResult["ERRORS"][] = "Неверный формат ID Инфоблока";
if ($iblock_id == 0) $arResult["ERRORS"][] = "Не настроен ID Инфоблока";
if (!$arResult["ERRORS"]) {
	$dbItems = ElementTable::getList(array(
		'order' => array('SORT' => 'ASC'),
		'select' => array('ID', 'NAME', 'IBLOCK_ID'),
		'filter' => array('IBLOCK_ID' => intval($arResult["IBLOCK_ID"])),
		'count_total' => 1,
		));
	$iblock = IblockTable::getByPrimary($iblock_id, array('select' => array('NAME')));
	$arResult["IBLOCK_NAME"] = $iblock->fetch()["NAME"];
	$arResult["ELEMENTS"] = $dbItems->fetchAll();
	$arResult["ELEMENTS_COUNT"] = $dbItems->getCount();
}

$this->IncludeComponentTemplate();
