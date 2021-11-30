<?php
IncludeModuleLangFile(__FILE__);

$module_id = htmlspecialchars($_REQUEST['mid'] != '' ? $_REQUEST['mid'] : $_REQUEST['id']);
CModule::IncludeModule($module_id);

$arIBlocks=Array("0" => " ≡ НЕ ВЫБРАНО ≡ ");
$db_iblock = CIBlock::GetList(Array("iblock_type" => "asc"));
while($iblock = $db_iblock->Fetch())
	$arIBlocks[$iblock["ID"]] = $iblock["NAME"]." (".$iblock["ID"].")";


$aTabs = array(
    array(
        'DIV'     => 'edit1',
        'TAB'     => GetMessage('IBELMCNT_OPTIONS_TAB_GENERAL'),
        'TITLE'   => GetMessage('IBELMCNT_OPTIONS_TAB_TITLE'),
        'OPTIONS' => array(
            array(
                'iblock_id',
                GetMessage('IBELMCNT_OPTIONS_IB_SELECT'),
                '0',
                array('selectbox', $arIBlocks)
            ),
						array('note' => GetMessage('IBELMCNT_OPTIONS_NOTE', array("#MODULE_ID#" => $module_id))),
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
           value="<?= GetMessage('IBELMCNT_OPTIONS_INPUT_APPLY'); ?>" class="adm-btn-save" />
</form>

<?php
$tabControl->end();

if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) continue;
            if ($arOption['note']) continue;
            if ($_REQUEST['apply']) {
                $optionValue = $_REQUEST[$arOption[0]];
                COption::SetOptionString($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);
            }
        }
    }

    LocalRedirect($APPLICATION->getCurPage().'?mid='.$module_id.'&lang='.LANGUAGE_ID);

}
?>