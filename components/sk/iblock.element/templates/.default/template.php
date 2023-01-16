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
<?if(!empty($arResult["ERROR_MESSAGE"])):?>
<?foreach($arResult["ERROR_MESSAGE"] as $v):?>
	<p class="sk-error"><?=$v?></p>
<?endforeach?>
<?else:?>
<?foreach($arResult["CURR"] as $k => $item):?>
	<p><?=$k?>: <?=$item?> Changed by <?=$arResult["CHANGE_VALUE"]?><?=($arResult["CHANGE_MODE"] == "P" ? "%" : "")?>: <?=$arResult["CHANGED"][$k]?></p>
<?endforeach?>
<?endif?>