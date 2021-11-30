<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Количество элементов Инфоблока (SK)");?><?$APPLICATION->IncludeComponent(
	"sk:iblock.elements.count",
	"",
Array(),
false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>