<?php
if (!check_bitrix_sessid()){
    return;
}

IncludeModuleLangFile(__FILE__);

if ($errorException = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(
        GetMessage('IBELMCNT_UNINSTALL_FAILED').': '.$errorException->GetString()
    );
} else {
    CAdminMessage::ShowNote(
        GetMessage('IBELMCNT_UNINSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?= GetMessage('IBELMCNT_RETURN_MODULES'); ?>">
</form>