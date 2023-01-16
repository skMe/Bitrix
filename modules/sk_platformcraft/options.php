<?php
IncludeModuleLangFile(__FILE__);

$module_id = htmlspecialchars($_REQUEST['mid'] != '' ? $_REQUEST['mid'] : $_REQUEST['id']);
CModule::IncludeModule($module_id);


$aTabs = array(
    array(
        'DIV'     => 'edit1',
        'TAB'     => GetMessage('SKPC_OPTIONS_TAB_GENERAL'),
        'TITLE'   => GetMessage('SKPC_OPTIONS_TAB_TITLE'),
        'OPTIONS' => array(
            array(
                'pc_login',
                GetMessage('SKPC_OPTIONS_PC_LOGIN'),
                '',
                array('text', 32),
            ),
            array(
                'pc_pass',
                GetMessage('SKPC_OPTIONS_PC_PASS'),
                '',
                array('password', 32),
            ),
						array('note' => GetMessage('SKPC_OPTIONS_NOTE')),
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
           value="<?= GetMessage('SKPC_OPTIONS_INPUT_APPLY'); ?>" class="adm-btn-save" />
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