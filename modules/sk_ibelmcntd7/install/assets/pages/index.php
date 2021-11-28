<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Количество элементов Инфоблока D7 (SK)");?><?$APPLICATION->IncludeComponent(
	"sk:iblock.elements.count.d7",
	"",
Array(),
false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>