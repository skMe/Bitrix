<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$curr = array(
	"EUR" => GetMessage("SK_CURR_EUR"),
	"USD" => GetMessage("SK_CURR_USD"),
	"RUB" => GetMessage("SK_CURR_RUB")
);
$arComponentParameters = array(
	"PARAMETERS" => array(
		"CURRENCIES" => Array(
			"NAME" => GetMessage("SK_CURRS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y",
			"SIZE"=>"5",
			"VALUES" => $curr,
			"DEFAULT"=>"", 
			"PARENT" => "DATA_SOURCE",
		),
		"BASE_CURR" => Array(
			"NAME" => GetMessage("SK_BASE_CURR"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"N",
			"VALUES" => $curr,
			"DEFAULT"=>"EUR", 
			"PARENT" => "DATA_SOURCE",
		),
		"DEF_EUR" => Array(
			"NAME" => GetMessage("SK_DEF_EUR"), 
			"TYPE" => "STRING",
			"DEFAULT" => "79.28", 
			"PARENT" => "VISUAL",
		),
		"DEF_USD" => Array(
			"NAME" => GetMessage("SK_DEF_USD"), 
			"TYPE" => "STRING",
			"DEFAULT" => "64.06", 
			"PARENT" => "VISUAL",
		),
		"CHANGE_CURR" => Array(
			"NAME" => GetMessage("SK_CHANGE_CURR"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>3600),
	)
);


?>