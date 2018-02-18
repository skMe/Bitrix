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
//dmp($arResult);
?>
	<div class="yamap">
		<div id="yamap" class="yamap__map"></div>
<?if($arParams["PLATE"] == "Y"):?>
		<div class="yamap__block plate">
			<div class="plate__title"><?=$arParams["NAME"]?></div>
			<div class="plate__title"><?=$arParams["ADDRESS"]?></div>
			<div class="plate__phone"><svg><use xlink:href="#phone"></svg><a href="tel:<?=(str_replace(array("(", ")", "-", " "), "", $arParams["PHONE"]))?>"><?=$arParams["PHONE"]?></a></div>
			<div class="plate__mail"><svg><use xlink:href="#email"></svg><a href="mailto:<?=$arParams["MAIL"]?>"><?=$arParams["MAIL"]?></a></div>
			<div class="plate__agree"><?=$arParams["~CONSENT"]?></div>
		</div>
<?endif?>
		<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru-Ru"></script>
		<script type="text/javascript">
			ymaps.ready(function(){
				var mainMap = new ymaps.Map('yamap', {
						center: [<?=$arParams["LAT_CENTER"]?>, <?=$arParams["LON_CENTER"]?>],
						zoom: <?=$arParams["ZOOM"]?>,
						behaviors: ['drag', 'dblClickZoom', 'multiTouch'],
						controls: ['zoomControl']
					}, {autoFitToViewport: 'always'}),
					myPlacemark = new ymaps.Placemark([<?=$arParams["LAT_POINT"]?>, <?=$arParams["LON_POINT"]?>], {
						hintContent: "<?=$arParams["POINT_TITLE"]?>"
					}, {
						iconLayout: 'default#image',
						iconImageHref: '<?=$templateFolder?>/img/point.svg',
						iconImageSize: [50, 66], iconImageOffset: [-25, -66],
					});
				mainMap.geoObjects.add(myPlacemark);
			});
		</script>
	</div>
