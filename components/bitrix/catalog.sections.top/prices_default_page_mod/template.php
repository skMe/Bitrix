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

<section class="projects-section">
    <div class="projects-section__container">

            <? if (!empty($arResult["SECTIONS"])): ?>
            <ul class="nav nav-pills projects-section__tabs-list_price d-none d-md-flex">
                <? $list_flag = 0; ?>
    <? foreach ($arResult["SECTIONS"] as $arSection): ?>
        <? if (!empty($arSection['ITEMS'])): ?>
                        <li><a data-toggle="pill"
                               href="#projects_<?= $arSection["ID"] ?>" <?= ($list_flag == 0) ? ' class="active show" ' : '' ?> ><?= $arSection["NAME"] ?></a>
                        </li>
                        <? $list_flag++; ?>
        <? endif; ?>
    <? endforeach; ?>
            </ul>
            <div class="d-md-none projects-section__tab-panel-nav" id="projectsTabPanel">
                <a class="projects-section__dropdown-tab-panel collapsed" role="button" data-toggle="collapse"
                   href="#collapseTabsPanel" aria-expanded="false" aria-controls="collapseTabsPanel">
                    <?= $arResult["SECTIONS"][0]["NAME"]; ?>
                </a>
                <div class="projects-section__list-group collapse" id="collapseTabsPanel">
                    <? $list_flag = 0; ?>
                    <? foreach ($arResult["SECTIONS"] as $arSection): ?>
                           <? if (!empty($arSection['ITEMS'])): ?>
                            <a class="projects-section__list-group-item<?= ($list_flag == 0) ? ' active' : '' ?>"
                               data-toggle="pill" href="#projects_<?= $arSection["ID"] ?>"><?= $arSection["NAME"] ?></a>
                                <? $list_flag++; ?>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
            </div>

            <div class="tab-content">
                <? $tab_flag = 0; ?>

            <? foreach ($arResult["SECTIONS"] as $arSection): ?>

                    <div id="projects_<?= $arSection['ID'] ?>"
                         class="projects-section__tab-panel tab-pane <?= ($tab_flag == 0) ? 'active' : '' ?>">
                            <? if (!empty($arSection["ITEMS"])): ?>
                            <div class="owl-carousel owl-theme price_list_owl">

                                <?
                                foreach ($arSection["ITEMS"] as $arElement):
                                    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                                    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCST_ELEMENT_DELETE_CONFIRM')));
                                    ?>
                                    <div class="item" id="<?= $this->GetEditAreaId($arElement['ID']) ?>">
                                        <div class="price-cnt">


                                            <div class="price_img"
                                                 style="background-image: url(<?= $arElement["PREVIEW_PICTURE"]["SRC"] ?>)"></div>
                                            <div class="price-period">
                                                <p><?= $arElement["NAME"] ?></p>
                                            </div>
                                            <div class="price-note">
                                                <? if (!empty($arElement["DISPLAY_PROPERTIES"])): ?>
                                                    <? foreach ($arElement["DISPLAY_PROPERTIES"]['FIELD_DESC']['VALUE'] as $key => $item): ?>
                                                        <div class="goods_row clearfix">
                                                            <div class="goods_name_cnt">
                                                                <span class="goods_name"><?= $item ?></span>
                                                            </div>
                                                            <div class="item_prop_border"></div>
                                                            <div class="goods_price">
                                                                <span class="goods_price_block"><?= $arElement["DISPLAY_PROPERTIES"]['FIELD_DESC']['DESCRIPTION'][$key] ?></span>
                                                            </div>
                                                        </div>

                                                    <? endforeach; ?>
                                                <? endif; ?>
                                            </div>
                                            <div class="prices_cnt">
                                                <div class="price"><?= $arElement["PRICES"]["base"]["PRINT_VALUE"] ?></div>
                                                <div class="old_price"><?= $arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"] ?></div>
                                            </div>
<?
if (isset($arResult["BASKET_ITEMS"][$arElement["ID"]])) {
	$cls_add = " in_basket";
	$btn_link = $arParams["BASKET_URL"];
	$btn_text = "В корзине";
} else {
	$cls_add = "";
	$btn_link = $arElement["ADD_URL"];
	$btn_text = "Добавить в корзину";
}
?>
                                            <div class="price_list_btn<?=$cls_add?>">
                                                <a href="<?=$btn_link?>"><?=$btn_text?></a>
																								<span>
																									<svg viewBox="0 0 40 30" version="1.1" xmlns="http://www.w3.org/2000/svg">
																										<circle class="point one" cx="5" cy="25" r="5" />
																										<circle class="point two" cx="20" cy="25" r="5" />
																										<circle class="point three" cx="35" cy="25" r="5" />
																									</svg>
																								</span>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                         <? endif; ?>

                    </div>
                <? $tab_flag++; ?>

            <? endforeach ?>

            </div>
<? endif; ?>
    </div>
</section>
