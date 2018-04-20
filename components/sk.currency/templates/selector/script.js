var cc_name = 'CURR_VAL';
var cc_days = 30;

$(document).ready(function(){

	var curr_base = getCookie(cc_name)
	if (!curr_base) {
		setCookie(cc_name, curr_data.BASE, cc_days);
		curr_base = curr_data.BASE;
	}
	if (curr_base != curr_data.BASE) convertPrice(curr_base, curr_data[curr_base].MULTY);

	$('.curr_selector_item').click(function(e){
		e.preventDefault();
		if ($(this).hasClass('selected')) return;
		var code = $(this).attr('data-curr-code');
		convertPrice(code, curr_data[code].MULTY);
	});

});
function convertPrice(code, multy) {
	$('.curr_sign').html(curr_data[code].SIGN);
	$('.curr_btn').attr('title', curr_data[code].NAME);
	$('.curr_selector_item').removeClass('selected');
	$('[data-curr-code=' + code + ']').addClass('selected');
	$('[data-price]').each(function(){
		var price = '' + Math.ceil($(this).attr('data-price') * multy);
		$(this).html(price.replace(/(\d)(?=(\d{3})+$)/g, '$1&nbsp;') + '&nbsp;' + curr_data[code].SIGN);
	});
	setCookie(cc_name, code, cc_days);
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var re = new RegExp("(?:^|; )" + cname.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)");
	var matches = document.cookie.match(re);
	return matches ? decodeURIComponent(matches[1]) : false;
}