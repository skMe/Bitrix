<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/functions.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/functions.php");


AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

function bxModifySaleMails($orderID, &$eventName, &$arFields) {
	$arOrder = CSaleOrder::GetByID($orderID);

	$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	$phone="";
	$index = ""; 
	$country_name = "";
	$city_name = "";  
	$address = "";
	$fio = "";
	$order_list_mod = "<table class=\"orderlist\">\n";
	while ($arProps = $order_props->Fetch()) {
		if ($arProps["CODE"] == "PHONE")  $phone = htmlspecialchars($arProps["VALUE"]);
		if ($arProps["CODE"] == "ZIP") $index = $arProps["VALUE"];   
		if ($arProps["CODE"] == "ADDRESS") $address = $arProps["VALUE"];
		if ($arProps["CODE"] == "FIO") $fio = $arProps["VALUE"];   
		if ($arProps["CODE"] == "LOCATION") {
			$arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
			$country_name =  $arLocs["COUNTRY_NAME_ORIG"];
			$city_name = $arLocs["CITY_NAME_ORIG"];
		}
	}

	$full_address = $index.", ".$country_name.", ".$city_name.", ".$address;

	$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
	$delivery_name = "";
	if ($arDeliv) $delivery_name = $arDeliv["NAME"];

	$arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	$pay_system_name = "";
	if ($arPaySystem) $pay_system_name = $arPaySystem["NAME"];
	$c = 1;
	$all_summ = 0;
	$curr = "RUB";
	$dbBasketItems = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $orderID));
	while ($arItems = $dbBasketItems->Fetch()) {
		$arBasketItems[] = $arItems;
		$order_list_mod .= "	<tr class=\"orderlist_row\">\n";
		$order_list_mod .= "		<td class=\"orderlist_num\">".$c.".</td>\n";
		$order_list_mod .= "		<td class=\"orderlist_name\"><a href=\"".$arItems["DETAIL_PAGE_URL"]."\" target=\"_blank\">".$arItems["NAME"]."</a></td>\n";
		$order_list_mod .= "		<td class=\"orderlist_quant\">".$arItems["QUANTITY"]."&nbsp;".$arItems["MEASURE_NAME"].".</td>\n";
		$order_list_mod .= "		<td class=\"orderlist_price\">".CCurrencyLang::CurrencyFormat($arItems["PRICE"], $arItems["CURRENCY"], true)."</td>\n";
		$order_list_mod .= "		<td class=\"orderlist_summ\">".CCurrencyLang::CurrencyFormat($arItems["PRICE"] * $arItems["QUANTITY"], $arItems["CURRENCY"], true)."</td>\n";
		$order_list_mod .= "	</tr>\n";
		$c++;
		$all_summ += $arItems["PRICE"] * $arItems["QUANTITY"];
		$curr = $arItems["CURRENCY"];
	}
	$order_list_mod .= "	<tr class=\"orderlist_row\">\n"
		."		<td colspan=\"3\"></td>\n"
		."		<td class=\"orderlist_total_text\"><b>хрнцн:</b></td>\n"
		."		<td class=\"orderlist_total_summ\"><b>".CCurrencyLang::CurrencyFormat($all_summ, $curr, true)."</b></td>\n"
		."	</tr>\n</table>\n";

	$arFields["ORDER_DESCRIPTION"] = $arOrder["USER_DESCRIPTION"]; 
	$arFields["FIO"] = $fio;
	$arFields["PHONE"] = $phone;
	$arFields["DELIVERY_NAME"] =  $delivery_name;
	$arFields["DELIVERY_PRICE"] = CCurrencyLang::CurrencyFormat($arOrder["PRICE_DELIVERY"], "RUB", true); 
	$arFields["PAY_SYSTEM_NAME"] =  $pay_system_name;
	$arFields["FULL_ADDRESS"] = $full_address;
	$arFields["ORDER_LIST_MOD"] = $order_list_mod;
	$arFields["BASKET_ITEMS"] = $arBasketItems;
}
?>