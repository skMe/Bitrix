<?
$header = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/prolog_before.php" : "/bitrix/header.php";
$footer = $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" ? "/bitrix/modules/main/include/epilog_after.php" : "/bitrix/footer.php";
require($_SERVER["DOCUMENT_ROOT"].$header);
$APPLICATION->SetTitle("Заявка на сотрудничество");
?>
<?$APPLICATION->IncludeComponent(
	"divier:sk.feedback",
	"cooperation",
	Array(
		"AJAX" => "Y",
		"AJAX_PATH" => "/ajax/form.php",
		"COMPONENT_TEMPLATE" => "cooperation",
		"EVENT_MESSAGE_ID" => array(0=>"9",),
		"OK_TEXT" => "Спасибо,<br>Ваше сообщение принято.<br>В ближайшее время мы свяжемся с Вами для дальнейшего сотрудничества.",
		"REQUIRED_FIELDS" => array(0=>"NAME",1=>"EMAIL"),
		"USE_CAPTCHA" => "Y",
		"USE_FIELDS" => array(0=>"NAME",1=>"PHONE",2=>"EMAIL",3=>"FIELD1",4=>"MESSAGE",)
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"].$footer);?>