requirejs([
	'jquery',
	'ScrollMagic',
	'animation.gsap',
	'debug.addIndicators',
	'enquire',
	'swiper'

], function ($, ScrollMagic) {

	'use strict';

	function profileNavSwiper() {
		enquire
			.register("screen and (max-width : 640px)", {
				match : function profileNavSwiper() {
					var profileNav = new Swiper('.swiper-container', {
						slidesPerView: 'auto',
						centeredSlides: true,
						grabCursor: true
					});
				},
				unmatch : function() {
					profileNav.destroy();
				}
			});
	}
	profileNavSwiper();


	sharePopup();
	function sharePopup() {
		enquire
			.register("screen and (max-width : 640px)", {
				match : function sharePopup() {
					controller.enabled(false);
					console.log('acdsvcds');
					$('.price-block').removeAttr('style');
				},
				unmatch : function() {
					$('.price-block').attr('style');
					console.log('sfvdfv');
				}
			})
	}

	var controller = new ScrollMagic.Controller();

	var scene = new ScrollMagic.Scene({
		offset: 10,
		duration: 1000

	})
	.setTween(".price-block", 2, {css:{paddingLeft:"0", paddingRight:"0"}, ease:Power2.easeOut})
	.addTo(controller);

	new ScrollMagic.Scene({
		triggerElement: "header",
		offset: 900,
		reverse: true
	})

	.setClassToggle(".price-block", "js-del-shadow") // add class toggle
	.addTo(controller);



});

