<?
$header = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/prolog_before.php" : "/bitrix/header.php";
$footer = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/epilog_after.php" : "/bitrix/footer.php";
require($_SERVER["DOCUMENT_ROOT"].$header);
$APPLICATION->SetTitle("Обратный звонок");
?>
<?$APPLICATION->IncludeComponent(
	"divier:sk.feedback",
	"callback",
	Array(
		"AJAX" => "Y",
		"AJAX_PATH" => "/ajax/form.php",
		"COMPONENT_TEMPLATE" => "callback",
		"EVENT_MESSAGE_ID" => array(0=>"8",),
		"OK_TEXT" => "Спасибо,<br>ваше сообщение принято.<br>В ближайшее время мы свяжемся с Вами",
		"REQUIRED_FIELDS" => array(0=>"NAME",1=>"PHONE",),
		"USE_CAPTCHA" => "Y",
		"USE_FIELDS" => array(0=>"NAME",1=>"PHONE",)
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"].$footer);?>