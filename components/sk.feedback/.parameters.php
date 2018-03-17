<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arFilter = Array("ACTIVE" => "Y");
$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arUse = Array(
	"NAME" => GetMessage("SK_NAME"),
	"PHONE" => GetMessage("SK_PHONE"),
	"TIME" => GetMessage("SK_TIME"),
	"EMAIL" => GetMessage("SK_MAIL"),
	"FILE" => GetMessage("SK_FILE"),
	"FIELD1" => GetMessage("SK_FIELD1"),
	"FIELD2" => GetMessage("SK_FIELD2"),
	"FIELD3" => GetMessage("SK_FIELD3"),
	"MESSAGE" => GetMessage("SK_MESSAGE")
);
$arReq = array();
foreach ($arCurrentValues['USE_FIELDS'] as $val) { $arReq[$val] = $arUse[$val]; }
//$arReq = array_filter($arUse, function($k) use ($arCurrentValues) {return  in_array($k, $arCurrentValues['USE_FIELDS']); }, ARRAY_FILTER_USE_KEY);

//print_r($arCurrentValues['USE_FIELDS']);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("SK_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"OK_TEXT" => Array(
			"NAME" => GetMessage("SK_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("SK_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		"USE_FIELDS" => Array(
			"NAME" => GetMessage("SK_USE_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y",
			"REFRESH" => "Y",
			"VALUES" => $arUse,
			"DEFAULT"=>"", 
			"SIZE"=>9, 
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("SK_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $arReq,
			"DEFAULT"=>"", 
			"SIZE"=>4, 
			"PARENT" => "BASE",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("SK_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"SIZE"=>8, 
			"PARENT" => "BASE",
		),
		"AJAX" => Array(
			"NAME" => GetMessage("SK_AJAX"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"REFRESH" => "Y",
			"PARENT" => "BASE",
		),
	)
);
if ($arCurrentValues['AJAX'] == "Y") {
	$arComponentParameters["PARAMETERS"]["AJAX_PATH"] = array(
		"NAME" => GetMessage("SK_AJAX_PATH"), 
		"TYPE" => "FILE",
		"FD_TARGET" => "F",
		"FD_EXT" => "php",
		"FD_UPLOAD" => false,
		"PARENT" => "BASE",
		"DEFAULT" => "$componentPath/ajax/form.php", 
	);
}


?>