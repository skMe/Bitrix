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
dmp($arResult);
?>

<div class="pc__wrap">
<?/* ### ERRORS ### */?>
<?if ($arResult["ERRORS"]) {?>
<?foreach ($arResult["ERRORS"] as $err) {?>
	<p class="pc_error"><?=$err?></p>
<?}?>
<?}?>
<?/* ### BROADCAST ### */?>
<?if ($arParams["MODE"] == "broadcast") {?>
<?if ($arResult["NOW"]) {?>
<?foreach ($arResult["NOW"] as $arItem) {?>
	<p><?=$arItem["start"]?> - <?=$arItem["stop"]?> <b><?=$arItem["name"]?></b> (<?=$arItem["duration"]?>)</p>
<?}?>
<?} else {?>
<?if ($arParams["NOW_TXT"]) {?>
	<p><?=$arParams["NOW_TXT"]?></p>
<?}?>
<?}?>
<?if ($arResult["NEXT"]) {?>
<?foreach ($arResult["NEXT"] as $arItem) {?>
	<p><?=$arItem["start"]?> - <?=$arItem["stop"]?> <b><?=$arItem["name"]?></b> (<?=$arItem["duration"]?>)</p>
<?}?>
<?}?>
<?/* ### RELEASES ### */?>
<?} elseif ($arParams["MODE"] == "releases") {?>
<?if ($arResult["RELEASES"]["ITEMS"]) {?>
<?foreach ($arResult["RELEASES"]["ITEMS"] as $arItem) {?>
	<p><b><?=$arItem["name"]?></b><br><?=$arItem["description"]?></p>
<?=$arItem["frame_tag"]?>
<?}?>
<?}?>
<?/* ### SCHEDULE ### */?>
<?} elseif ($arParams["MODE"] == "schedule") {?>
<?if ($arResult["SCHEDULE"]) {?>
<?foreach ($arResult["SCHEDULE"] as $arDay) {?>
	<div class="day_item <?=$arDay["STATUS"]?>">
		<h3 class="day_title"><?=$arDay["WEEKDAY"]?>, <?=$arDay["DAYMONTH"]?> <?=$arDay["YEAR"]?></h3>
<?if ($arDay["ITEMS"]) {?>
<?foreach ($arDay["ITEMS"] as $arItem) {?>
		<p class="<?=$arItem["status"]?>"><?=$arItem["start"]?> - <?=$arItem["stop"]?> <?=$arItem["name"]?></p>
<?}?>
<?}?>
	</div>
<?}?>
<?}?>
<?}?>
</div>