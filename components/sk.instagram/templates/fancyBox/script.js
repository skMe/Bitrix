$(document).ready(function() {
	$('[data-fancybox]').fancybox({
		protect : true,
		toolbar : false,
		smallBtn : true,
		caption : function( instance, item ) {
			return $(this).parent().find('.insta-caption').html();
		}
	});
});