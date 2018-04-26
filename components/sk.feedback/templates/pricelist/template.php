<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<?$product = htmlspecialchars(substr($_GET["product"], 0, 50));?>
<div class="popup">
	<form class="popup__form afjrxm" action="<?=POST_FORM_ACTION_URI?>" method="POST"<?if(in_array("FILE", $arParams["USE_FIELDS"])):?> enctype="multipart/form-data"<?endif?>>
<?=bitrix_sessid_post()?>
		<span class="popup__title">Запрос<br>прайслиста для<br><span class="popup__subtitle"><?=$product?></span></span>
<?
if(!empty($arResult["ERROR_MESSAGE"])) {
	foreach($arResult["ERROR_MESSAGE"] as $v) ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0) {
	echo $arResult["OK_MESSAGE"];
}
?>
		<input type="hidden"<?=(in_array("FIELD1", $arParams["REQUIRED_FIELDS"]) ? ' required="required"' : '')?> name="field1" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? $product : $_POST["field1"])?>" />
		<input class="popup__input"<?=(in_array("NAME", $arParams["REQUIRED_FIELDS"]) ? ' required="required"' : '')?> title="Имя" placeholder="Имя" type="text" name="name" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["name"])?>" size="5" />
		<input class="popup__input popup__input_type_email"<?=(in_array("EMAIL", $arParams["REQUIRED_FIELDS"]) ? ' required="required"' : '')?> title="Email" placeholder="Email" type="text" name="email" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["email"])?>" size="5" />
		<textarea class="popup__input popup__message"<?=(in_array("MESSAGE", $arParams["REQUIRED_FIELDS"]) ? ' required="required"' : '')?> title="Сообщение" placeholder="Сообщение" name="message"><?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["message"])?></textarea>
<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<input class="captcha_sid" type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<div class="captcha_bg"><img class="captcha_img" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"></div>
		<input class="popup__input" type="text" name="captcha_word" title="Текст с картинки" placeholder="Текст с картинки" size="5" maxlength="10" value="">
<?endif;?>
		<button class="popup__button button" type="submit">Отправить</button>
		<span class="popup__conf">отправляя форму, я даю
			<a href="/confidentiality/" target="_blank">согласие на обработку</a> персональных данных</span>
<?if($arParams["AJAX"] == "Y"):?>
		<input type="hidden" name="ph" value="<?=$arParams["PH"]?>">
		<input type="hidden" name="pm" value="<?=$arParams["PM"]?>">
		<input type="hidden" name="ajax" value="y">
<?endif?>
	</form>
<?if($arParams["AJAX"] == "Y"):?>
<?CJSCore::Init(array("jquery"))?>
<script type="text/javascript">
function afjrxmInit() {
	$(".afjrxm").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var form_data = new FormData(form.get(0));
		form.find('.afjrxm_err_msg').remove();
		form.find('.afjrxm_err').removeClass('afjrxm_err');
		$.ajax({
			type: "POST",
			url: "<?=$arParams["AJAX_PATH"]?>",
			data: form_data,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.success) {
					$('.afjrxm').replaceWith(response.msg);
				} else {
					for (var prop in response.msg) {
						$('[name="' + prop + '"]').addClass('afjrxm_err').before('<span class="afjrxm_err_msg">' + response.msg[prop] + '</span>');
					}
				}
			}
		});
	});

};
afjrxmInit();
</script>
<?endif?>
</div>
