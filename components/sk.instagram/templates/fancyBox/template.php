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
//dmp($arResult);
?>
<?if(!empty($arResult["ERROR_MESSAGE"])):?>
<?foreach($arResult["ERROR_MESSAGE"] as $v):?>
	<p class="insta-error"><?=$v?></p>
<?endforeach?>
<?else:?>
<?if($arParams["HEADER_TEXT"]):?>
<h3><?=$arParams["HEADER_TEXT"]?></h3>
<?endif?>
<?if($arParams["ACCOUNT_IMG"] == "Y" || $arParams["ACCOUNT_FULL_NAME"] == "Y"|| $arParams["FOLLOW"] == "Y" || $arParams["BIOGRAPHY"] == "Y"):?>
<div class="insta-head-block clearfix">
<?if($arParams["ACCOUNT_IMG"] == "Y"):?>
	<img src="<?=$arResult["PROFILE_PIC_URL"]?>" alt="<?=$arResult["USERNAME"]?>-img" class="account-img">
<?endif?>
<?if($arParams["ACCOUNT_FULL_NAME"] == "Y"):?>
	<p><a href="<?=$arResult["EXTERNAL_URL"]?>"><?=$arResult["FULL_NAME"]?> (<?=$arResult["USERNAME"]?>)</a></p>
<?else:?>
	<p><a href="<?=$arResult["EXTERNAL_URL"]?>"><?=$arResult["USERNAME"]?></a></p>
<?endif?>
<?if($arParams["FOLLOW"] == "Y"):?>
	<p class="insta-follow"><?=GetMessage("DV_FOLLOWED_BY")?>: <span><?=$arResult["FOLLOWED_BY"]?></span> <?=GetMessage("DV_FOLLOWS")?>: <span><?=$arResult["FOLLOWS"]?></span></p>
<?endif?>
<?if($arParams["BIOGRAPHY"] == "Y"):?>
	<p class="insta-bio"><?=$arResult["BIOGRAPHY"]?></p>
<?endif?>
</div>
<?endif?>
<div class="insta-images-block clearfix">
<?foreach($arResult["ITEMS"] as $item):?>
	<div class="insta-image">
		<a data-fancybox="fb-gal" href="<?=($arParams["IMG_LINK"] ? $item["IMG"]["SRC"] : 'https://www.instagram.com/p/'.$item["INSTA_CODE"])?>" title="<?=$item["INSTA_CODE"]?>" target="_blank">
			<img src="<?=$item["THUMB"]["SRC"]?>" alt="">
		</a>
<?if($arParams["IMG_EXTRA"] == "Y"):?>
		<p>
			<?=GetMessage("DV_EXTRA_DATE")?>: <span class="insta-date"><?=$item["DATE"]?> <?=GetMessage("DV_EXTRA_TIME")?> <span class="insta-time"><?=$item["TIME"]?></span>
			<?=GetMessage("DV_EXTRA_LIKES")?>: <span class="insta-likes"><?=$item["LIKES"]?> <?=GetMessage("DV_EXTRA_COMMENTS")?>: <span class="insta-comments"><?=$item["COMMENTS"]?>
		</p>
<?endif?>
<?if($arParams["IMG_CAPTION"] == "Y"):?>
		<p class="insta-caption"><?=$item["CAPTION"]?></p>
<?endif?>
	</div>
<?endforeach?>
</div>
<?endif?>