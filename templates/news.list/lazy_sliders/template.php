<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
//dmp($arResult);
?>
<?if($arResult["SEC_INFO"]["DESC"]):?>
<?=$arResult["SEC_INFO"]["DESC"]?>
<?endif?>
<?foreach($arResult["ITEMS"] as $k => $arItem):?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
	<h4><i><?=($k + 1)?>. <?=$arItem["NAME"]?></i></h4>
<?if($arItem["PROPERTIES"]["SLIDER_IMGS"]["VALUE"]):?>
	<div class="lazy_slick" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
<?foreach($arItem["SLIDER_IMGS"] as $img):?>
		<div><div class="lazy_slick__item"><img alt="<?=$img["DESC"]?>" data-lazy="<?=$img["IMG"]?>"></div></div>
<?endforeach?>
	</div>
<?endif?>
<?endforeach?>
<script>
$(document).ready(function() {
	$('.lazy_slick').slick({
		lazyLoad: 'progressive',
		slidesToShow: 3,
		slidesToScroll: 3,
		nextArrow: '<div class="lazy_slick-next"></div>',
		prevArrow: '<div class="lazy_slick-prev"></div>'
	});
});
</script>