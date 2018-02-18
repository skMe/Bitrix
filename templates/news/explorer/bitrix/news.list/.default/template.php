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
<div style="display:none;">
	<svg xmlns="http://www.w3.org/2000/svg">
		<symbol id="folder" viewBox="0 0 512 512">
			<path fill="currentColor" d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48z"></path>
		</symbol>
		<symbol id="file" viewBox="0 0 384 512">
			<path fill="currentColor" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm160-14.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"></path>
		</symbol>
	</svg>
</div>
<ul class="explorer">
<?if ($arResult["SECTIONS"]):?>
<?foreach($arResult["SECTIONS"] as $arSec):?>
<?
$this->AddEditAction($arSec['ID'], $arSec['EDIT_LINK'], CIBlock::GetArrayByID($arSec["IBLOCK_ID"], "SECTION_EDIT"));
$this->AddDeleteAction($arSec['ID'], $arSec['DELETE_LINK'], CIBlock::GetArrayByID($arSec["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
?>
	<li class="folder" id="<?=$this->GetEditAreaId($arSec['ID']);?>"><a href="<?=$arSec["SECTION_PAGE_URL"]?>"><svg><use xlink:href="#folder"/></svg> <?=$arSec["NAME"]?></a></li>
<?endforeach?>
<?endif?>
<?if($arResult["ITEMS"]):?>
<?foreach($arResult["ITEMS"] as $arItem):?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
	<li class="file" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><svg><use xlink:href="#file"/></svg> <?=$arItem["NAME"]?></a></li>
<?endforeach?>
<?endif?>
</ul>
