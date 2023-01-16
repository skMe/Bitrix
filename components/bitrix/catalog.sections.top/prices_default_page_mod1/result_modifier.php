<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult["CATALOG"]["BASKET_ITEMS"] = array();
$arFilter = array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",);
$arSel = array("ID", "NAME", "PRODUCT_ID", "QUANTITY", "CAN_BUY", "PRICE");
$res = CSaleBasket::GetList(array("ID"=>"ASC"), $arFilter, false, false, $arSel);
while ($ar_res = $res->Fetch()) {
	$arResult["CATALOG"]["BASKET_ITEMS"][$ar_res["PRODUCT_ID"]] = $ar_res;
}
foreach ($arResult["SECTIONS"] as &$arSec) {
	foreach ($arSec["ITEMS"] as &$arItem) {
		$arSort = array("SORT"=>"ASC");
		$arSelect = array("ID", "ACTIVE", "NAME", "PREVIEW_TEXT");
		$arOffParams = $arParams["OFFER_PROPERTIES"];
		$arOffers = CIBlockPriceTools::GetOffersArray($arItem["IBLOCK_ID"], array($arItem["ID"]), $arSort, $arSelect, $arOffParams, 0, $arResult["PRICES"], $arParams['PRICE_VAT_INCLUDE']);
		$arOffersVariants = $arOffersIds = array();
		foreach ($arOffers as &$offer) {
			$offer["BUY_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam($arParams["ACTION_VARIABLE"]."=BUY&".$arParams["PRODUCT_ID_VARIABLE"]."=".$offer["ID"], array($arParams["PRODUCT_ID_VARIABLE"], $arParams["ACTION_VARIABLE"])));
			$offer["ADD_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam($arParams["ACTION_VARIABLE"]."=ADD2BASKET&".$arParams["PRODUCT_ID_VARIABLE"]."=".$offer["ID"], array($arParams["PRODUCT_ID_VARIABLE"], $arParams["ACTION_VARIABLE"])));
			$offer["COMPARE_URL"] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_TO_COMPARE_LIST&id=".$offer["ID"], array($arParams["PRODUCT_ID_VARIABLE"], $arParams["ACTION_VARIABLE"])));
			$offerid = array();
			foreach ($offer["PROPERTIES"] as $k => $arOProp) {
				if (!$arOProp["VALUE"] || $k == "CML2_LINK") continue;
				if (!array_key_exists($k, $arOffersVariants)) $arOffersVariants[$k] = array("name" => $arOProp["~NAME"], "items" => array());
				if (!array_key_exists($arOProp["VALUE_XML_ID"], $arOffersVariants[$k]["items"])) $arOffersVariants[$k]["items"][$arOProp["VALUE_XML_ID"]] = $arOProp["~VALUE"];
				$offerid[] = $arOProp["VALUE_XML_ID"];
			}
			$arOffersIds[implode("_", $offerid)] = array("id" => $offer["ID"], "img" => $offer["PREVIEW_PICTURE"]["SRC"], "name" => $offer["NAME"], "desc" => $offer["PREVIEW_TEXT"]);
		}
		$arItem["OFFERS"] = $arOffers;
		$arItem["OFFERS_VARIANTS"] = $arOffersVariants;
		if ($arOffersIds) $arResult["CATALOG"]["OFFERS_SETS"][$arItem["ID"]] = $arOffersIds;
	}
}
?>