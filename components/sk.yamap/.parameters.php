<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arPlate = array(
	"NAME" => array(
		"NAME" => GetMessage("SK_NAME"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"ADDRESS" => array(
		"NAME" => GetMessage("SK_ADDRESS"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"PHONE" => array(
		"NAME" => GetMessage("SK_PHONE"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"FAX" => array(
		"NAME" => GetMessage("SK_FAX"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"MAIL" => array(
		"NAME" => GetMessage("SK_MAIL"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"CONSENT" => array(
		"NAME" => GetMessage("SK_CONSENT"), 
		"TYPE" => "STRING",
		"COLS" => "55",
		"ROWS" => "3",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"LAT_CENTER" => array(
			"NAME" => GetMessage("SK_LAT_CENTER"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"LON_CENTER" => array(
			"NAME" => GetMessage("SK_LON_CENTER"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"LAT_POINT" => array(
			"NAME" => GetMessage("SK_LAT_POINT"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"LON_POINT" => array(
			"NAME" => GetMessage("SK_LON_POINT"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"POINT_TITLE" => Array(
			"NAME" => GetMessage("SK_POINT_TITLE"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"ZOOM" => Array(
			"NAME" => GetMessage("SK_ZOOM"), 
			"TYPE" => "LIST",
			"DEFAULT" => "9", 
			"VALUES" => array('7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '19'),
			"PARENT" => "VISUAL",
		),
		"PLATE" => array(
			"NAME" => GetMessage("SK_PLATE"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
			'REFRESH' => 'Y',
		),
	)
);

if ($arCurrentValues["PLATE"] == "Y") $arComponentParameters["PARAMETERS"] += $arPlate;
 
?>