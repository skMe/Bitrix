<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()) {
    return;
}

if ($errorException = $APPLICATION->GetException()) {
    CAdminMessage::ShowMessage(
        Loc::getMessage('IBELMCNT_INSTALL_FAILED').': '.$errorException->GetString()
    );
} else {
    CAdminMessage::ShowNote(
        Loc::getMessage('IBELMCNT_INSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?= Loc::getMessage('IBELMCNT_RETURN_MODULES'); ?>">
</form>