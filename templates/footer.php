
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
		</main>
		<div class="footer">
			<div class="wrapper footer__wrapper">
				<div class="footer__item footer__item_type_logo">
					<a class="footer__logo-link" href="/">
						<img class="footer__img" src="<?=SITE_TEMPLATE_PATH?>/images/gh-logo.svg" alt="гостевой дом GuestHouse" />
					</a>
				</div>
<?$APPLICATION->IncludeComponent(
	"divier:sk.text", 
	"contacts_bot", 
	array(
		"TEXT1" => "8-800-350-7414",
		"TEXT2" => "8-800-350-7414",
		"TEXT3" => "Амурская область,<br> г. Свободный, пер. Парковый 12/1, кв. 2",
		"COMPONENT_TEMPLATE" => "contacts_bot"
	),
	false
);?>
			</div>
			<div class="wrapper">
				<button class="button-order footer__button" type="button">Заказать звонок</button>
				<div class="socials footer__socials">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"social",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "social",
		"USE_EXT" => "N"
	)
);?>
				</div>
			</div>
		</div>
		<div class="popup" style="display: none;">
			<div class="popup__wrapper divier_ajax_form">
				<button class="popup__close" type="button"></button>
				<form class="popup__form" action="/local/ajax/feedback.php" method="POST">
					<input type="hidden" name="AJAX_CALL" value="Y" />
					<input type="hidden" name="TPL_ID" value="8" />
					<span class="popup__title">Оставьте заявку
						<br/>
						<span>и мы вам перезвоним</span>
					</span>
					<input class="popup__input popup__input_name" required="required" title="Ваше имя" placeholder="Ваше имя*" type="text" name="name" value="" size="5" />
					<input class="popup__input popup__input_phone" name="phone" required="required" title="Ваш телефон" type="text" placeholder="Ваш телефон*" value="" size="5" />
					<button class="popup__btn button" type="submit" value="submit">Отправить</button>
				</form>
			</div>
		</div>
	</body>
</html>
