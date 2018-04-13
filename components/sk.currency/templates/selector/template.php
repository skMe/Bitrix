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
$curr_data = array(
	"EUR" => array("NAME" => "Цены в евро", "SIGN" => "&#8364;",),
	"USD" => array("NAME" => "Цены в долларах", "SIGN" => "&#36;",),
	"RUB" => array("NAME" => "Цены в рублях", "SIGN" => "&#8381;",),
	"BASE" => $arResult["BASE_CURR"]
);
?>
<?if(!empty($arResult["ERROR_MESSAGE"])):?>
<?foreach($arResult["ERROR_MESSAGE"] as $v):?>
	<p class="sk-error"><?=$v?></p>
<?endforeach?>
<?else:?>
				<div class="curr_selector_wrap maxwidth-theme">
					<div class="curr_selector">
						<div class="dropdown">
							<button class="btn btn-sm dropdown-toggle curr_btn" title="<?=$curr_data[$arResult["BASE_CURR"]]["NAME"]?>" type="button" id="dropdownCurr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								<span class="curr_sign"><?=$curr_data[$arResult["BASE_CURR"]]["SIGN"]?></span><span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownCurr">
<?foreach($arResult["CHANGED"] as $k => $v):?>
								<li><a href="#" class="curr_selector_item<?=($k == $arResult["BASE_CURR"] ? ' selected' : '')?>" title="<?=$curr_data[$k]["NAME"]?>" data-curr-code="<?=$k?>"><?=$k?></a></li>
<?$curr_data[$k]["MULTY"] = $arResult["MULTY"][$k]?>
<?endforeach?>
							</ul>
						</div>
					</div>
				</div>
<?endif?>
<script>
	var curr_data = <?=json_encode($curr_data)?>;
</script>
