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
$arParams["WIDTH"] = intval($arParams["WIDTH"]);
$arParams["HEIGHT"] = intval($arParams["HEIGHT"]);
$arResult["LOOP"] = $arParams["LOOP"] == "Y" ? true : false;
$arResult["AUTOPLAY"] = $arParams["AUTOPLAY"] == "Y" ? true : false;
$arResult["AR"] = round(($arParams["HEIGHT"] / $arParams["WIDTH"] * 100), 2);
$this->IncludeComponentTemplate();
