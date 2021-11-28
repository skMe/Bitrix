<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Iblock\IblockTable;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request['mid'] != '' ? $request['mid'] : $request['id']);
Loader::includeModule($module_id);

$arIBlocks=Array("0" => " ≡ НЕ ВЫБРАНО ≡ ");
$db_iblock = IblockTable::GetList(Array('order' => array("IBLOCK_TYPE_ID" => "ASC")));
while($iblock = $db_iblock->fetch())
	$arIBlocks[$iblock["ID"]] = $iblock["NAME"]." (".$iblock["ID"].")";


$aTabs = array(
    array(
        'DIV'     => 'edit1',
        'TAB'     => Loc::getMessage('IBELMCNT_OPTIONS_TAB_GENERAL'),
        'TITLE'   => Loc::getMessage('IBELMCNT_OPTIONS_TAB_TITLE'),
        'OPTIONS' => array(
            array(
                'iblock_id',
                Loc::getMessage('IBELMCNT_OPTIONS_IB_SELECT'),
                '0',
                array('selectbox', $arIBlocks)
            ),
						array('note' => Loc::getMessage('IBELMCNT_OPTIONS_NOTE', array("#MODULE_ID#" => $module_id))),
        )
    ),
);

$tabControl = new CAdminTabControl(
    'tabControl',
    $aTabs
);

$tabControl->begin();
?>
<form action="<?= $APPLICATION->getCurPage(); ?>?mid=<?=$module_id; ?>&lang=<?= LANGUAGE_ID; ?>" method="post">
    <?= bitrix_sessid_post(); ?>
    <?php
    foreach ($aTabs as $aTab) {
        if ($aTab['OPTIONS']) {
            $tabControl->beginNextTab();
            __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
        }
    }
    $tabControl->buttons();
    ?>
    <input type="submit" name="apply" 
           value="<?= Loc::GetMessage('IBELMCNT_OPTIONS_INPUT_APPLY'); ?>" class="adm-btn-save" />
</form>

<?php
$tabControl->end();

if ($request->isPost() && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) continue;
            if ($arOption['note']) continue;
            if ($request['apply']) {
                $optionValue = $request->getPost($arOption[0]);
                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);
            }
        }
    }

    LocalRedirect($APPLICATION->getCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID);

}
?>