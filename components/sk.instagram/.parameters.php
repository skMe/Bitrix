<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"INST_ACCOUNT" => Array(
			"NAME" => GetMessage("DV_INST_ACCOUNT"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "BASE",
		),
		"THUMB_SIZE" => Array(
			"NAME" => GetMessage("DV_THUMB_SIZE"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"N",
			"VALUES" => array("0" => "150 x 150", "1" => "240 x 240", "2" => "320 x 320", "3" => "480 x 480", "4" => "640 x 640", "max" => GetMessage("DV_FULL_SIZE")),
			"DEFAULT"=>"", 
			"PARENT" => "DATA_SOURCE",
		),
		"IMG_LINK" => Array(
			"NAME" => GetMessage("DV_IMG_LINK"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"N", 
			"VALUES" => array("0" => GetMessage("DV_IMG_LINK_PAGE"), "1" => GetMessage("DV_IMG_LINK_IMG")),
			"DEFAULT"=>"0", 
			"PARENT" => "DATA_SOURCE",
		),
		"HEADER_TEXT" => Array(
			"NAME" => GetMessage("DV_HEADER_TEXT"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"ACCOUNT_FULL_NAME" => Array(
			"NAME" => GetMessage("DV_ACCOUNT_FULL_NAME"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"ACCOUNT_IMG" => Array(
			"NAME" => GetMessage("DV_ACCOUNT_IMG"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"BIOGRAPHY" => Array(
			"NAME" => GetMessage("DV_BIOGRAPHY"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"FOLLOW" => Array(
			"NAME" => GetMessage("DV_FOLLOW"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"IMG_EXTRA" => Array(
			"NAME" => GetMessage("DV_IMG_EXTRA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"IMG_CAPTION" => Array(
			"NAME" => GetMessage("DV_IMG_CAPTION"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>3600),
	)
);


?>