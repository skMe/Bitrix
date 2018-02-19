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
$i = 0;
?>
<div class="content_block">
	<div class="container padding_60_0">
		<div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
<?if($i == 6):?>
		</div>
		<div class="row padding_top_60">
<?$i = 0;?>
<?endif?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
				<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="col-xs-2 padding_0_10 text-center">
					<a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arItem["CODE"]?>" title="<?=$arItem["PREVIEW_TEXT"];?>" data-fancybox>
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["CODE"]?>" class="img-responsive">
					</a>
					<div class="b_item_text"><?=$arItem["NAME"];?></div>
				</div>
<?$i++;?>
<?endforeach;?>
		</div>
	</div>
</div>
