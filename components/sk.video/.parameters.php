<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"VIDEO" => array(
			"NAME" => GetMessage("SK_VIDEO"), 
			"TYPE" => "FILE",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
			"FD_TARGET" => "F",
			"FD_EXT" => "mp4,wbm",
			"FD_UPLOAD" => true,
			"FD_USE_MEDIALIB" => true,
			"FD_MEDIALIB_TYPES" => array('video'),
		),
		"POSTER" => array(
			"NAME" => GetMessage("SK_POSTER"), 
			"TYPE" => "FILE",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
			"FD_TARGET" => "F",
			"FD_EXT" => "png,jpg,jpeg,gif",
			"FD_UPLOAD" => true,
			"FD_USE_MEDIALIB" => true,
			"FD_MEDIALIB_TYPES" => array('image'),
		),
		"WIDTH" => array(
			"NAME" => GetMessage("SK_WIDTH"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"HEIGHT" => array(
			"NAME" => GetMessage("SK_HEIGHT"), 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "VISUAL",
		),
		"AUTOPLAY" => Array(
			"NAME" => GetMessage("SK_AUTOPLAY"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"LOOP" => Array(
			"NAME" => GetMessage("SK_LOOP"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "VISUAL",
		),
		"NOT_SUPPORT" => array(
			"NAME" => GetMessage("SK_NOT_SUPPORT"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("SK_NOT_SUPPORT_TEXT"), 
			"PARENT" => "VISUAL",
		),
	)
);

?>