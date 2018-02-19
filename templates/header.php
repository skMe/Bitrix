<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta content="IE=edge" http-equiv="X-UA-Compatible" />
		<meta http-equiv="msthemecompatible" content="no" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="format-detection" content="address=no" />
		<meta name="HandheldFriendly" content="True" />
		<meta http-equiv="cleartype" content="on" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<meta name="application-name" content="Title" />
		<meta name="msapplication-tooltip" content="Description" />
		<meta name="theme-color" content="#ffffff" />
		<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/images/favicon.ico" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&amp;subset=cyrillic" rel="stylesheet" />
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/vendors/css/normalize.css");?>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/vendors/css/slick.css");?>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/styles.css");?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/vendors/js/jquery.min.js");?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/vendors/js/inputmask.min.js");?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/vendors/js/inputmask.phone.extensions.min.js");?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/vendors/js/slick.min.js");?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scripts.js");?>
<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle()?></title>
	</head>
	<body>
<?$APPLICATION->ShowPanel()?>
		<noscript class="noscript">
			<div class="wrapper">У вас отключен JavaScript. Сайт может отображаться некорректно. Рекомендуем включить JavaScript.</div>
		</noscript>
		<div class="header">
			<div class="wrapper header__wrapper">
				<div class="header__item header__item_type_logo">
					<a class="header__logo-link" href="/">
						<img class="header__img" src="<?=SITE_TEMPLATE_PATH?>/images/gh-logo.svg" alt="гостевой дом GuestHouse" />
					</a>
				</div>
<?$APPLICATION->IncludeComponent(
	"divier:sk.text", 
	"contacts_top", 
	array(
		"TEXT1" => "8-800-350-7414",
		"TEXT2" => "8-800-350-7414",
		"TEXT3" => "Амурская область,<br> г. Свободный, пер. Парковый 12/1, кв. 2",
		"COMPONENT_TEMPLATE" => "contacts_top"
	),
	false
);?>
			</div>
			<div class="wrapper">
				<button class="button-order header__button" type="button">Заказать звонок</button>
			</div>
		</div>
		<main class="main-content">
