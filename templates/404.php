<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("404 - Ничего не найдено");
?>
<p>К сожалению, по Вашему запросу ничего не найдено</p>
<p>Попробуйте начать с <a href="/" title="<?=COption::GetOptionString("main", "site_name");?>">главной страницы</a></p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>