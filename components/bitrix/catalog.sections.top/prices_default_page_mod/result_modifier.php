<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult["BASKET_ITEMS"] = array();
$arFilter = array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL",);
$arSel = array("ID", "NAME", "PRODUCT_ID", "QUANTITY", "CAN_BUY", "PRICE");
$res = CSaleBasket::GetList(array("ID"=>"ASC"), $arFilter, false, false, $arSel);
while ($ar_res = $res->Fetch()) {
	$arResult["BASKET_ITEMS"][$ar_res["PRODUCT_ID"]] = $ar_res;
}
?>