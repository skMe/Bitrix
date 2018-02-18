<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
//dmp($arParams);
?>
	<div class="video">
		<div class="adaptive">
			<div class="adaptive__padding" style="padding-top:<?=$arResult["AR"]?>%;"></div>
			<div class="adaptive__content">
				<video class="dv_video" src="<?=$arParams["VIDEO"]?>" poster="<?=$arParams["POSTER"]?>"<?=($arResult["LOOP"] ? " loop" : "")?><?=($arResult["AUTOPLAY"] ? " autoplay" : "")?>>
					<?=$arParams["NOT_SUPPORT"]?>
				</video>
				<svg class="play_btn<?=($arResult["AUTOPLAY"] ? " ctrl_hidden" : "")?>"><use xlink:href="#playbtn"></svg>
				<svg class="pause_btn<?=($arResult["AUTOPLAY"] ? "" : " ctrl_hidden")?>"><use xlink:href="#pausebtn"></svg>
			</div>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function(){

	$('.play_btn').click(function(){
		var vEl = $(this).parent().find('video')[0];
		if (vEl.paused) {
			vEl.play();
			$(this).addClass('ctrl_hidden');
			$(this).parent().find('.pause_btn').removeClass('ctrl_hidden');
		}
	});

	$('.pause_btn').click(function(){
		var vEl = $(this).parent().find('video')[0];
		if (vEl.played) {
			vEl.pause();
			$(this).addClass('ctrl_hidden');
			$(this).parent().find('.play_btn').removeClass('ctrl_hidden');
		}
	});

});
</script>