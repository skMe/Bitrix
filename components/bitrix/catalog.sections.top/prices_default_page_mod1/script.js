$(document).ready(function() {
    $('.price_list_owl').owlCarousel({
		margin:0,
		navText: ['<div class="owl_btn-left"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="13.651" height="25.5" viewBox="0 0 13.651 25.5"><g id="right-arrow" transform="translate(47.051 32) rotate(180)"><path id="Path_57" data-name="Path 57" d="M34.939,31.736a.9.9,0,0,1-1.275,0,.9.9,0,0,1,0-1.275L44.875,19.25,33.664,8.039a.9.9,0,1,1,1.275-1.275L46.788,18.613a.9.9,0,0,1,0,1.275Z" class="carousel-arrow"></path></g></svg></a></div>', 
				  '<div class="owl_btn-right"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="13.651" height="25.5" viewBox="0 0 13.651 25.5"><g id="right-arrow" transform="translate(-33.4 -6.5)"><path id="Path_57" data-name="Path 57" d="M34.939,31.736a.9.9,0,0,1-1.275,0,.9.9,0,0,1,0-1.275L44.875,19.25,33.664,8.039a.9.9,0,1,1,1.275-1.275L46.788,18.613a.9.9,0,0,1,0,1.275Z" class="carousel-arrow"></path></g></svg></a></div>'],
        responsive:{
			0:{
				items:1,
				nav:false,
				dots:false,
			},
			768:{
				items:2,
				nav:false,
				dots:true,
			},
			992:{
				items:3,
				nav:false,
				dots:true,
			},
			1200:{
				items:4,
				nav:true,
				dots:false,
			}
		},
                margin: 20
		
	});
    
        $("#projectsTabPanel .projects-section__list-group-item").click(function(){
            $('#projectsTabPanel #collapseTabsPanel').collapse('hide');
            $('#projectsTabPanel .projects-section__list-group-item').removeClass('active');
            $(this).addClass('active');
            $('#projectsTabPanel .projects-section__dropdown-tab-panel').html($(this).html());
            var currentTab = $(this).attr("href");
            $(".projects-section__tab-panel.active").removeClass('active');
            $(currentTab).tab('show');
            return false;
        });
});

$(document).ready(function(){
	let buy_btns = $('a[href*="ADD2BASKET"]');
	buy_btns.each(function(){
		$(this).attr("rel", $(this).attr("href"));
	});
	buy_btns.attr("href","javascript:void(0);");

	$('a[rel*="ADD2BASKET"]').click(function(){
		let btn = $(this);
		btn.parent().addClass('cart_request');
		$.ajax({
			type: "GET",
			url: $(this).attr("rel"),
			data: {IS_AJAX: "Y", pid: $(this).data('pid')},
			dataType: "json",
			error: function() { btn.parent().removeClass('cart_request'); },
			success: function(resp){
				if (resp.success) {
					BX.onCustomEvent('OnBasketChange');
					btn.attr("href","/personal/cart/");
					btn.attr("rel","");
					btn.parent().removeClass('cart_request').addClass('in_basket');
					btn.text('В корзине');
					btn.off('click');
				} else {
					btn.parent().removeClass('cart_request');
				}
			}
		});
	});

	$('.offer_btn:not(.offer_sel)').click(function() {
		let btn = $(this);
		let el_id = btn.parents('.offers_item').data('eid');
		let offer_item = btn.parents('.show');
		let btn_id = btn.data('opid');
		let sel_id = btn.siblings('.offer_sel').data('opid');
		let current_set = '';
		offer_item.find('.offer_btn.offer_sel').each(function() {current_set += current_set ? '_' + $(this).data('opid') : $(this).data('opid');});
		let need_set = current_set.replace(sel_id, btn_id);
		let need_offer = 0;
		if (offers_sets.hasOwnProperty(el_id)) {
			if (offers_sets[el_id].hasOwnProperty(need_set)) {
				need_offer = offers_sets[el_id][need_set].id;
			} else {
				for (let key in offers_sets[el_id]) {
					if (key.indexOf(btn_id) === -1) continue;
					need_offer = offers_sets[el_id][key].id;
					break;
				}
			}
		}
		if (need_offer) {
			offer_item.removeClass('show');
			offer_item.siblings('[data-oid="' + need_offer + '"]').addClass('show');
		}
		//console.log(el_id, need_set, need_offer);
	});
});
