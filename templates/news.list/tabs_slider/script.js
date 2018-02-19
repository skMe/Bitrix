window.onload = function() {

	if(window.jQuery) {
		$('ul.pf_tabs__caption').on('click', 'li:not(.active)', function() {
			$(this)
				.addClass('active').siblings().removeClass('active')
				.closest('div.tabs').find('div.pf_tabs__content').removeClass('active').eq($(this).index()).addClass('active');
		});

		$(window).resize(rszCap);
		rszCap();

		function rszCap() {
			$('.pf_slide__caption p').each(function() {
				//console.log($(this).parent().find('img').width());
				$(this).css('max-width', $('.pf_slider__list').width() + 'px');
			});
		}

	}
};
