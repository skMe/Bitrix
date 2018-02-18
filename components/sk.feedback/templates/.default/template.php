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
<div class="sk-feedback">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="sk-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="post" class="sk_form">
<?=bitrix_sessid_post()?>
<?if(in_array("NAME", $arParams["USE_FIELDS"])):?>
	<div class="sk-name">
		<div class="sk-text">
			<?=GetMessage("SK_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="name" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["name"])?>">
	</div>
<?endif?>
<?if(in_array("EMAIL", $arParams["USE_FIELDS"])):?>
	<div class="sk-email">
		<div class="sk-text">
			<?=GetMessage("SK_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="email" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["email"])?>">
	</div>
<?endif?>
<?if(in_array("PHONE", $arParams["USE_FIELDS"])):?>
	<div class="sk-phone">
		<div class="sk-text">
			<?=GetMessage("SK_PHONE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="phone" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["phone"])?>">
	</div>
<?endif?>
<?if(in_array("TIME", $arParams["USE_FIELDS"])):?>
	<div class="sk-time">
		<div class="sk-text">
			<?=GetMessage("SK_TIME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("TIME", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<select name="time">
			<option value="0"><?=GetMessage("SK_TIME0")?></option>
			<option value="1"><?=GetMessage("SK_TIME1")?></option>
			<option value="2"><?=GetMessage("SK_TIME2")?></option>
		</select>
	</div>
<?endif?>
<?if(in_array("MESSAGE", $arParams["USE_FIELDS"])):?>
	<div class="sk-message">
		<div class="sk-text">
			<?=GetMessage("SK_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<textarea name="message" rows="5" cols="40"><?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["message"])?></textarea>
	</div>
<?endif?>
<?if(in_array("FILE", $arParams["USE_FIELDS"])):?>
	<div class="sk-file">
		<div class="sk-text">
			<?=GetMessage("SK_FILE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("FILE", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="file" name="file" value="">
	</div>
<?endif?>
<?if(in_array("FIELD1", $arParams["USE_FIELDS"])):?>
	<div class="sk-field1">
		<div class="sk-text">
			<?=GetMessage("SK_FIELD1")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("FIELD1", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="field1" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["field1"])?>">
	</div>
<?endif?>
<?if(in_array("FIELD2", $arParams["USE_FIELDS"])):?>
	<div class="sk-field2">
		<div class="sk-text">
			<?=GetMessage("SK_FIELD2")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("FIELD2", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="field2" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["field2"])?>">
	</div>
<?endif?>
<?if(in_array("FIELD3", $arParams["USE_FIELDS"])):?>
	<div class="sk-field3">
		<div class="sk-text">
			<?=GetMessage("SK_FIELD3")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("FIELD3", $arParams["REQUIRED_FIELDS"])):?><span class="sk-req">*</span><?endif?>
		</div>
		<input type="text" name="field3" value="<?=(empty($arResult["ERROR_MESSAGE"]) ? '' : $_POST["field3"])?>">
	</div>
<?endif?>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="sk-captcha">
		<div class="sk-text"><?=GetMessage("SK_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="sk-text"><?=GetMessage("SK_CAPTCHA_CODE")?><span class="sk-req">*</span></div>
		<input type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
	<input type="submit" value="<?=GetMessage("SK_SUBMIT")?>">
<?if($arParams["AJAX"] == "Y"):?>
	<input type="hidden" name="ph" value="<?=$arParams["PH"]?>">
	<input type="hidden" name="pm" value="<?=$arParams["PM"]?>">
	<input type="hidden" name="ajax" value="y">
<?endif?>
</form>
</div>
<?if($arParams["AJAX"] == "Y"):?>
<?CJSCore::Init(array("jquery"))?>
<script type="text/javascript">
$(document).ready(function(){
	$("body").append('<div class="sk_overlay"><div class="sk_popup"><div class="sk_popup__close">&times;</div><div class="sk_popup__title"></div><div class="sk_popup__text"></div></div></div>');
	$('.sk_popup__close').click(function(){
		$('.sk_overlay').fadeOut(300);
	});
	$(".sk_form").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var form_data = form.serialize();
		$.ajax({
			type: "POST",
			url: "<?=$arParams["AJAX_PATH"]?>",
			data: form_data,
			dataType: 'json',
			success: function(response) {
				console.log(response);
				if (response.success) {
					$('.sk_popup__title').html('УСПЕШНО!');
					$('.sk_popup__text').html(response.msg);
					form.trigger("reset");
				} else {
					$('.sk_popup__title').html('ОШИБКА!');
					$('.sk_popup__text').html(response.msg.join('<br>'));
				}
				$('.sk_overlay').css('display', 'flex').animate({opacity:'1'}, 300)
			}
		});
	});
});
</script>
<?endif?>
