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
?>
<div class="pf_slider tabs">
	<ul class="pf_tabs__caption">
<?foreach($arResult["TITLES"] as $k => $title):?>
		<li<?=($k ? '' : ' class="active"')?>><p><?=$title?></p></li>
<?endforeach?>
	</ul>
<?foreach($arResult["ITEMS"] as $k => $arItem):?>
	<div class="pf_tabs__content<?=($k ? '' : ' active')?>">
		<ul class="pf_slider__list <?=$arItem["CODE"]?>">
<?foreach($arItem["IMAGES"] as $arImg):?>
		<li class="pf_slider__item pf_slide">
			<a href="<?=$arImg["SRC"]?>" class="pf_slide__link <?=$arResult["SECTION"]["PATH"]["0"]["CODE"]?>_fb" data-caption="<?=$arImg["DESC"]?>">
				<img class="pf_slide__img" src="<?=$arImg["PREVIEW"]?>" alt="<?=$arImg["NAME"]?>">
			</a>
			<div class="pf_slide__caption"><p style="width:<?=($arImg["WIDTH"]-40)?>px;"><?=$arImg["DESC"]?></p></div>
		</li>
<?endforeach?>
		</ul>
	</div>
<script>
$(document).ready(function() {

	$('.<?=$arItem["CODE"]?>').slick({
		centerMode: true,
		variableWidth: true,
		centerPadding: '100px',
		slidesToShow: 1,
		slidesToScroll: 1,
		nextArrow: '<img class="pf_slider_rarr" src="<?=$templateFolder?>/img/arrow_right.svg" alt="right-arrow">',
		prevArrow: '<img class="pf_slider_larr" src="<?=$templateFolder?>/img/arrow_left.svg" alt="left-arrow">'
	});

});
</script>
<?endforeach;?>
</div>
<script>
$(document).ready(function() {

	$('.<?=$arResult["SECTION"]["PATH"]["0"]["CODE"]?>_fb').fancybox({
		padding: 0,
		openEffect : 'elastic',
		closeEffect : 'elastic',
		closeClick : true,
		helpers : {
			title : {
				type : 'over'
			}
		}
	});

});
</script>
