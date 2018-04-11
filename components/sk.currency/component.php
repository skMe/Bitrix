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

$arParams["CACHE_TIME"] = IntVal($arParams["CACHE_TIME"]);
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;
$arResult["ERROR_MESSAGE"] = array();

if ($this->StartResultCache()) {
	if($arParams["CURRENCIES"]) {
		$arResult["CHANGE_MODE"] = strpos($arParams["CHANGE_CURR"], "%") ? "P" : "N";
		$arResult["CHANGE_VALUE"] = floatval($arParams["CHANGE_CURR"]);
		$arResult["BASE_CURR"] = $arParams["BASE_CURR"];
		$xml = new DOMDocument();
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp';
		$list = array(); 
		if (@$xml->load($url)) {
			$root = $xml->documentElement;
			$items = $root->getElementsByTagName('Valute');
			foreach ($items as $item) {
				$code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
				$curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
				$list[$code] = round(floatval(str_replace(',', '.', $curs)), 4);
			}
		}
		$list["RUB"] = 1;
		foreach ($arParams["CURRENCIES"] as $val) {
			if ($list[$val]) {
				$arResult["CURR"][$val] = $list[$val];
			} else {
				$arResult["CURR"][$val] = round(floatval(str_replace(',', '.', $arParams["DEF_".$val])), 4);
			}
			if ($val == "RUB") {
				$arResult["CHANGED"]["RUB"] = 1;
			} else {
				$chgd = $arResult["CHANGE_MODE"] == "P" ? ($arResult["CURR"][$val] / 100 * $arResult["CHANGE_VALUE"] + $arResult["CURR"][$val]) : ($arResult["CURR"][$val] + $arResult["CHANGE_VALUE"]);
				$arResult["CHANGED"][$val] = round($chgd, 4);
			}
		}
		foreach ($arParams["CURRENCIES"] as $val) {
			$arResult["MULTY"][$val] = round(($arResult["CHANGED"][$arResult["BASE_CURR"]] / $arResult["CHANGED"][$val]), 4);
		}
	} else {
		$arResult["ERROR_MESSAGE"][] = GetMessage("SK_CURR_NOT_SEL");
	}
	$this->IncludeComponentTemplate();
}

