<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
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

<?
if (array_key_exists("IS_AJAX", $_REQUEST) && array_key_exists("pid", $_REQUEST)) {
$APPLICATION->RestartBuffer();
$err = "";
$resp = array("success" => true, "msg" => "OK");
if (!$err && !($pid = intval($_REQUEST["pid"]))) $err = "Неверное значение в параметре pid";
if (!$err && !array_key_exists($pid, $arResult["CATALOG"]["BASKET_ITEMS"])) $err = "Ошибка добавления товара в корзину";
if ($err) $resp = array("success" => false, "msg" => $err);
echo json_encode($resp);
die();
}
?>
<section class="projects-section">
	<div class="projects-section__container">

<?if (!empty($arResult["SECTIONS"])) {?>
		<ul class="nav nav-pills projects-section__tabs-list_price d-none d-md-flex">
<?$list_flag = 0;?>
<?foreach ($arResult["SECTIONS"] as $arSection) {?>
<?if (!empty($arSection['ITEMS'])) {?>
			<li><a data-toggle="pill" href="#projects_<?= $arSection["ID"] ?>" <?= ($list_flag == 0) ? ' class="active show" ' : '' ?> ><?= $arSection["NAME"] ?></a>
			</li>
<?$list_flag++;?>
<?}?>
<?}?>
		</ul>
		<div class="d-md-none projects-section__tab-panel-nav" id="projectsTabPanel">
			<a class="projects-section__dropdown-tab-panel collapsed" role="button" data-toggle="collapse"
				href="#collapseTabsPanel" aria-expanded="false" aria-controls="collapseTabsPanel">
				<?=$arResult["SECTIONS"][0]["NAME"];?>
			</a>
			<div class="projects-section__list-group collapse" id="collapseTabsPanel">
<?$list_flag = 0; ?>
<?foreach ($arResult["SECTIONS"] as $arSection) {?>
<?if (!empty($arSection['ITEMS'])) {?>
				<a class="projects-section__list-group-item<?= ($list_flag == 0) ? ' active' : '' ?>" data-toggle="pill" href="#projects_<?= $arSection["ID"] ?>"><?= $arSection["NAME"] ?></a>
<?$list_flag++;?>
<?}?>
<?}?>
			</div>
		</div>

		<div class="tab-content">
<?$tab_flag = 0;?>

<? foreach ($arResult["SECTIONS"] as $arSection) {?>

			<div id="projects_<?= $arSection['ID'] ?>" class="projects-section__tab-panel tab-pane <?= ($tab_flag == 0) ? 'active' : '' ?>">
<?if (!empty($arSection["ITEMS"])) {?>
				<div class="owl-carousel owl-theme price_list_owl">

<?
foreach ($arSection["ITEMS"] as $arElement) {
$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
?>
					<div class="item offers_item" id="<?= $this->GetEditAreaId($arElement['ID']) ?>" data-eid="<?=$arElement['ID']?>">
<?if ($arElement["OFFERS"]) {?>
<?foreach ($arElement["OFFERS"] as $k => $arOffer) {?>
						<div class="price-cnt offer-item<?=($k ? "" : " show")?>" data-oid="<?=$arOffer["ID"]?>">


							<div class="price_img" style="background-image: url(<?= $arOffer["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
							<div class="price-period"><p><?= $arOffer["NAME"] ?></p></div>
							<div class="price-desc"><p><?= $arOffer["PREVIEW_TEXT"] ?></p></div>
							<div class="price-note">
<? foreach ($arElement["OFFERS_VARIANTS"] as $k2 => $arProp) {?>
								<div class="goods_row clearfix">
									<div class="goods_name_cnt">
										<span class="goods_name"><?=$arProp["name"]?></span>
									</div>
									<div class="goods_price">
<?foreach ($arProp["items"] as $k3 => $item) {?>
<?$ocls = $arOffer["PROPERTIES"][$k2]["VALUE_XML_ID"] == $k3 ? " offer_sel" : ""?>
										<span class="goods_price_block offer_btn<?=$ocls?>" data-opid="<?=$k3?>"><?=$item?></span>
<?}?>
									</div>
								</div>

<?}?>
							</div>
							<div class="prices_cnt">
								<div class="price"><?= $arOffer["PRICES"]["base"]["PRINT_VALUE"] ?></div>
								<div class="old_price"><?= $arOffer["PROPERTIES"]["OLD_PRICE"]["VALUE"] ?></div>
							</div>
<?
if (isset($arResult["CATALOG"]["BASKET_ITEMS"][$arOffer["ID"]])) {
	$cls_add = " in_basket";
	$btn_link = $arParams["BASKET_URL"];
	$btn_text = "В корзине";
} else if ($arOffer["CAN_BUY"]) {
	$cls_add = "";
	$btn_link = $arOffer["ADD_URL"];
	$btn_text = "Добавить в корзину";
} else {
	$cls_add = "";
	$btn_link = "javascript:void(0);";
	$btn_text = "Нет в наличии";
}
?>
							<div class="price_list_btn<?=$cls_add?>">
								<a href="<?=$btn_link?>" data-pid="<?=$arOffer["ID"]?>"><?=$btn_text?></a>
								<span>
									<svg viewBox="0 0 40 30" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<circle class="point one" cx="5" cy="25" r="5" />
										<circle class="point two" cx="20" cy="25" r="5" />
										<circle class="point three" cx="35" cy="25" r="5" />
									</svg>
								</span>
							</div>
						</div>
<?}?>
<?} else {?>

						<div class="price-cnt">
							<div class="price_img" style="background-image: url(<?= $arElement["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
							<div class="price-period"><p><?= $arElement["NAME"] ?></p></div>
							<div class="price-desc"><p><?= $arElement["PREVIEW_TEXT"] ?></p></div>
							<div class="price-note">
<? if (!empty($arElement["DISPLAY_PROPERTIES"])) {?>
<? foreach ($arElement["DISPLAY_PROPERTIES"] as $arProp) {?>
								<div class="goods_row clearfix">
									<div class="goods_name_cnt">
										<span class="goods_name"><?=$arProp["NAME"]?></span>
									</div>
									<div class="item_prop_border"></div>
									<div class="goods_price">
										<span class="goods_price_block"><?=$arProp["VALUE"]?></span>
									</div>
								</div>

<?}?>
<?}?>
							</div>
							<div class="prices_cnt">
								<div class="price"><?= $arElement["PRICES"]["base"]["PRINT_VALUE"] ?></div>
								<div class="old_price"><?= $arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"] ?></div>
							</div>
<?
if (isset($arResult["CATALOG"]["BASKET_ITEMS"][$arElement["ID"]])) {
	$cls_add = " in_basket";
	$btn_link = $arParams["BASKET_URL"];
	$btn_text = "В корзине";
} else if ($arElement["CAN_BUY"]) {
	$cls_add = "";
	$btn_link = $arElement["ADD_URL"];
	$btn_text = "Добавить в корзину";
} else {
	$cls_add = "";
	$btn_link = "javascript:void(0);";
	$btn_text = "Нет в наличии";
}
?>
							<div class="price_list_btn<?=$cls_add?>">
								<a href="<?=$btn_link?>" data-pid="<?=$arElement["ID"]?>"><?=$btn_text?></a>
								<span>
									<svg viewBox="0 0 40 30" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<circle class="point one" cx="5" cy="25" r="5" />
										<circle class="point two" cx="20" cy="25" r="5" />
										<circle class="point three" cx="35" cy="25" r="5" />
									</svg>
								</span>
							</div>
						</div>

<?}?>
					</div>
<?}?>
				</div>
<?}?>

			</div>
<?$tab_flag++;?>

<?}?>

		</div>
<?}?>
<script>
let offers_sets = <?=json_encode($arResult["CATALOG"]["OFFERS_SETS"])?>
</script>
	</div>
</section>
