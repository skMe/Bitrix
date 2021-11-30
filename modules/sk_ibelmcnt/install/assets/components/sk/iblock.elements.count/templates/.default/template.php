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
<?if ($arResult["ERRORS"]):?>
<p>Обнаружены ошибки:</p>
<ul>
<?foreach ($arResult["ERRORS"] as $err):?>
	<li><?=$err?></li>

<?endforeach;?>
</ul>
<?else:?>
<p>В Инфоблоке «<?=$arResult["IBLOCK_NAME"]?> (<?=$arResult["IBLOCK_ID"]?>)» содержится <?=$arResult["ELEMENTS_COUNT"]?> элементов</p>
<?if ($arResult["ELEMENTS"]):?>
<ol>
<?foreach ($arResult["ELEMENTS"] as $elm):?>
	<li><?=$elm["NAME"]?></li>

<?endforeach;?>
</ol>
<?endif;?>
<?endif;?>