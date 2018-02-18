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
<h1 class="elm__title"><?=$arResult["NAME"]?></h1>
<a class="elm__link" href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img class="elm__image" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" /></a>
<p class="elm__text"><?=$arResult["DETAIL_TEXT"]?></p>
