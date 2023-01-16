<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arModeBroadcast = array(
	"CHANNEL_NAME" => array(
		"NAME" => GetMessage("PC_CHANNEL_NAME"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"NOW_TXT" => array(
		"NAME" => GetMessage("PC_NOW_TXT"), 
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("PC_NOW_DEF"), 
		"PARENT" => "VISUAL",
	),
	"DEF_DESCR" => array(
		"NAME" => GetMessage("PC_DEF_DESCR"), 
		"TYPE" => "STRING",
		"COLS" => "55",
		"ROWS" => "3",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"NEXT_CNT" => array(
		"NAME" => GetMessage("PC_NEXT_CNT"), 
			"TYPE" => "LIST",
			"DEFAULT" => "6", 
			"VALUES" => array("1" => "1","2" => "2","3" => "3","4" => "4","5" => "5","6" => "6","7" => "7","8" => "8","9" => "9","10" => "10"),
		"PARENT" => "VISUAL",
	),
);

$arModeReleases = array(
	"DIR_NAME" => array(
		"NAME" => GetMessage("PC_DIR_NAME"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"ITEMS_PP" => array(
		"NAME" => GetMessage("PC_ITEMS_PP"), 
			"TYPE" => "LIST",
			"DEFAULT" => "6", 
			"VALUES" => array("1" => "1","2" => "2","3" => "3","4" => "4","5" => "5","6" => "6","7" => "7","8" => "8","9" => "9","10" => "10"),
		"PARENT" => "VISUAL",
	),
);

$arModeSchedule = array(
	"CHANNEL_NAME" => array(
		"NAME" => GetMessage("PC_CHANNEL_NAME"), 
		"TYPE" => "STRING",
		"DEFAULT" => "", 
		"PARENT" => "VISUAL",
	),
	"PERIOD" => array(
		"NAME" => GetMessage("PC_PERIOD"), 
			"TYPE" => "LIST",
			"DEFAULT" => "1", 
			"VALUES" => array("1" => GetMessage("PC_PERIOD_DAY"),"2" => GetMessage("PC_PERIOD_WEEK"),"3" => GetMessage("PC_PERIOD_MONTH")),
		"PARENT" => "VISUAL",
	),
);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"MODE" => Array(
			"NAME" => GetMessage("PC_MODE"), 
			"TYPE" => "LIST",
			"DEFAULT" => "broadcast", 
			"VALUES" => array("broadcast" => GetMessage("PC_MODE_BROADCAST"),"releases" => GetMessage("PC_MODE_RELEASES"),"schedule" => GetMessage("PC_MODE_SCHEDULE")),
			"PARENT" => "VISUAL",
			'REFRESH' => 'Y',
		),
	)
);

if ($arCurrentValues["MODE"] == "" || $arCurrentValues["MODE"] == "broadcast") $arComponentParameters["PARAMETERS"] += $arModeBroadcast;
if ($arCurrentValues["MODE"] == "releases") $arComponentParameters["PARAMETERS"] += $arModeReleases;
if ($arCurrentValues["MODE"] == "schedule") $arComponentParameters["PARAMETERS"] += $arModeSchedule;

?>