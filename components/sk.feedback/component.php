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

$arTimes = array('0' => GetMessage("SK_TIME0"), '1' => GetMessage("SK_TIME1"), '2' => GetMessage("SK_TIME2"));
$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["OK_TEXT"] = trim($arParams["~OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("SK_OK_MESSAGE");

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$arResult["ERROR_MESSAGE"] = array();
	if(check_bitrix_sessid()) {
		if ($arParams["REQUIRED_FIELDS"]) {
			if(in_array("NAME", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["name"]) <= 1)$arResult["ERROR_MESSAGE"]["name"] = GetMessage("SK_REQ_NAME");
			if(in_array("EMAIL", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["email"]) <= 1)$arResult["ERROR_MESSAGE"]["email"] = GetMessage("SK_REQ_EMAIL");
			if(in_array("MESSAGE", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["message"]) <= 3) $arResult["ERROR_MESSAGE"]["message"] = GetMessage("SK_REQ_MESSAGE");
			if(in_array("PHONE", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["phone"]) <= 1) $arResult["ERROR_MESSAGE"]["phone"] = GetMessage("SK_REQ_PHONE");
			if(in_array("TIME", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["time"]) <= 1) $arResult["ERROR_MESSAGE"]["time"] = GetMessage("SK_REQ_TIME");
			if(in_array("FILE", $arParams["REQUIRED_FIELDS"]) && empty($_FILES["file"]["tmp_name"])) $arResult["ERROR_MESSAGE"]["file"] = GetMessage("SK_REQ_FILE");
			if(in_array("FIELD1", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["field1"]) <= 1) $arResult["ERROR_MESSAGE"]["field1"] = GetMessage("SK_REQ_FIELD1");
			if(in_array("FIELD2", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["field2"]) <= 1) $arResult["ERROR_MESSAGE"]["field2"] = GetMessage("SK_REQ_FIELD2");
			if(in_array("FIELD3", $arParams["REQUIRED_FIELDS"]) && strlen($_POST["field3"]) <= 1) $arResult["ERROR_MESSAGE"]["field3"] = GetMessage("SK_REQ_FIELD3");
		}
		if(strlen($_POST["email"]) > 1 && !check_email($_POST["email"])) $arResult["ERROR_MESSAGE"]["email"] = GetMessage("SK_EMAIL_NOT_VALID");
		if(strlen($_POST["phone"]) > 1 && !check_phone($_POST["phone"])) $arResult["ERROR_MESSAGE"]["phone"] = GetMessage("SK_PHONE_NOT_VALID");
		if(empty($arParams["EVENT_MESSAGE_ID"])) $arResult["ERROR_MESSAGE"]["event"] = GetMessage("SK_EVENT_EMPTY");
		if($arParams["USE_CAPTCHA"] == "Y") {
			include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0) {
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)) $arResult["ERROR_MESSAGE"]["captcha_word"] = GetMessage("SK_CAPTCHA_WRONG");
			} else {
				$arResult["ERROR_MESSAGE"]["captcha_word"] = GetMessage("SK_CAPTHCA_EMPTY");
			}
		}
		if(empty($arResult["ERROR_MESSAGE"])) {
			$files = $fnames = array();
			
			foreach ($_FILES as $file) {
				if (!empty($file['tmp_name'])) {
					$files[] = CFile::SaveFile($file, 'attach');
					$fnames[] = $file['name'];
				}
			}
			$arFields = Array(
				"NAME" => $_POST["name"],
				"EMAIL" => $_POST["email"],
				"PHONE" => $_POST["phone"],
				"TIME" => $arTimes[$_POST["time"]],
				"FILE" => implode(", ", $fnames),
				"FIELD1" => $_POST["field1"],
				"FIELD2" => $_POST["field2"],
				"FIELD3" => $_POST["field3"],
				"MESSAGE" => $_POST["message"],
			);
			foreach($arParams["EVENT_MESSAGE_ID"] as $v) {
				if(IntVal($v) > 0) CEvent::Send("SK_FORM", SITE_ID, $arFields, "N", IntVal($v), $files);
			}
			if($_POST["ajax"] != "y") LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
		}
	} else {
		$arResult["ERROR_MESSAGE"][] = GetMessage("SK_SESS_EXP");
	}
} elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"]) {
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$arParams["PH"] = base64_encode(serialize(array($arParams["EVENT_MESSAGE_ID"],$arParams["USE_FIELDS"],$arParams["REQUIRED_FIELDS"],$arParams["USE_CAPTCHA"],$arParams["OK_TEXT"])));
$arParams["PM"] = md5($arParams["PH"]."zn5k8CoAx7Ypx7ZHx8pcFnA8QHOTnf0w");

if($_POST["ajax"] == "y") {
	if(empty($arResult["ERROR_MESSAGE"])) {
		$resp = array("success" => true, "msg" => $arParams["OK_TEXT"], "captcha" => $arResult["capCode"]);
	} else {
		$resp = array("success" => false, "msg" => $arResult["ERROR_MESSAGE"]);
	}
	echo json_encode($resp);
} else {
	$this->IncludeComponentTemplate();
}

function check_phone($num) {
	$num = preg_replace("/\D/", "", $num);
	return preg_match("/^[78]\d{10}$/", $num);
}