<?
if ($_POST["pm"] != md5($_POST["ph"]."zn5k8CoAx7Ypx7ZHx8pcFnA8QHOTnf0w")) {
	echo json_encode(array("success" => false, "msg" => array("Неверные параметры запроса")));
} else {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	//var_dump($_SERVER);
	$arPr = unserialize(base64_decode($_POST["ph"]));
	$APPLICATION->IncludeComponent(
		"divier:sk.feedback",
		"",
		Array(
			"EVENT_MESSAGE_ID" => $arPr[0],
			"USE_FIELDS" => $arPr[1],
			"REQUIRED_FIELDS" => $arPr[2],
			"USE_CAPTCHA" => $arPr[3],
			"OK_TEXT" => $arPr[4]
		)
	);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
}
?>