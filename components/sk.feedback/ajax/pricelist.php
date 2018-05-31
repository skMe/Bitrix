<?
$header = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/prolog_before.php" : "/bitrix/header.php";
$footer = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/epilog_after.php" : "/bitrix/footer.php";
require($_SERVER["DOCUMENT_ROOT"].$header);
$APPLICATION->SetTitle("Запрос прайс-листа");
?>
<?$APPLICATION->IncludeComponent(
	"divier:sk.feedback",
	"pricelist",
	Array(
		"AJAX" => "Y",
		"AJAX_PATH" => "/ajax/form.php",
		"COMPONENT_TEMPLATE" => "pricelist",
		"EVENT_MESSAGE_ID" => array(0=>"10",),
		"OK_TEXT" => "Спасибо,<br>Ваше сообщение принято.<br>В ближайшее время мы отправим Вам прайс-лист на указанный Email.",
		"REQUIRED_FIELDS" => array(0=>"NAME",1=>"EMAIL",2=>"FIELD1",),
		"USE_CAPTCHA" => "Y",
		"USE_FIELDS" => array(0=>"NAME",1=>"EMAIL",2=>"MESSAGE",3=>"FIELD1",)
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"].$footer);?>