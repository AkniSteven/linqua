requirejs([
	'jquery',
	'ScrollMagic',
	'isotope.pkgd',
	'animation.gsap',
	'TweenMax',
	'debug.addIndicators',
	'enquire'
//	'swiper'

], function ($, ScrollMagic, Isotope) {

	'use strict';


//	function iosHeightFix() {
//
//		var ua = navigator.userAgent.toLowerCase();
////		ui = (navigator.userAgent.match('CriOS'));
//		var vHeight = 200;
//
//		if (ua.indexOf('safari') != -1) {
//			alert('safari');
////			if (ua.indexOf('Chrome') > -1) {
////				$('.language-banner').css({
////					height: '100vh'
////				});
////				alert('asd');
////			} else {
////				$('.language-banner').height($(window).height() / 1 - vHeight);
////			}
//		} else if(ua.match('CriOS') > -1) {
//			alert('chrome')
//		}
//		$(window).resize(function () {
//			if (ua.indexOf('safari') != -1) {
//				if (ua.indexOf('chrome') > -1) {
//				} else {
//					$('.language-banner').height($(window).height() / 1 - vHeight);
//				}
//			}
//		});
//
////		var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
////		if (isiPad > -1) {
////			$('.language-banner').height($(window).height() / 1 - vHeight);
////		}
////
////		$(window).resize(function () {
////			if (isiPad > -1) {
////				$('.language-banner').height($(window).height() / 1 - vHeight);
////			}
////		});
//	}
//
//	iosHeightFix();

	/*scroll-responsive price-block*/

	var controller = new ScrollMagic.Controller();

	new ScrollMagic.Scene({
		offset: 10,
		duration: 1000
	})
		.setTween(".full", 2, {css: {width: "100vw"}, ease: Power2.easeOut})
		.addTo(controller);

	new ScrollMagic.Scene({
//		triggerElement: "header",
		offset: 250,
		reverse: true
	})
		.setClassToggle(".full", "js-del-shadow") // add class toggle
		.addTo(controller);

	new ScrollMagic.Scene({
		offset: 10,
		reverse: true
	})
		.setClassToggle(".price-block", "js-del-status") // add class toggle
		.addTo(controller);

	/* end scroll-responsive price-block*/

//	function profileNavSwiper() {
//		enquire
//			.register("screen and (max-width : 640px)", {
//				match : function profileNavSwiper() {
//					var profileNav = new Swiper('.swiper-container', {
//						slidesPerView: 'auto',
//						centeredSlides: true,
//						grabCursor: true
//					});
//				},
//				unmatch : function() {
//					profileNav.destroy();
//				}
//			});
//	}
//	profileNavSwiper();

	function priceCellChangePosition() {
		var priceBlockCell = $('.price-block__tariff-cell'),
			priceBlockHolder = $('.price-block-wrapper');
		enquire
			.register("screen and (max-width : 783px)", {
				match: function priceCellChangePosition() {
					if (priceBlockCell.length > 2) {
						priceBlockHolder.addClass('js-restructuring-cells');
					} else {
						console.log('not-done');
					}
				},
				unmatch: function () {
					if (priceBlockCell.length > 2) {
						priceBlockHolder.removeClass('js-restructuring-cells');
					} else {
						console.log('not-done');
					}
				}
			});
	}

	priceCellChangePosition();


	var projGrid = document.querySelector('#container');
//	if (projGrid) {
		var iso = new Isotope(projGrid, {
//			itemSelector: '.grid-item',
			getSortData : {
				name : function ( $elem ) {
					return $($elem).find('.name').text();
				},
				symbol : function ( $elem ) {
					return $($elem).find('.symbol').text();
				}
			}
		});

//	}
	$( document ).ready(function() {
		var projGrid = document.querySelector('.isotope');
		// filter buttons
		$('.lp-community__filter-item a').click(function(e){
			event.preventDefault();
			var $this = $(this);
			// don't proceed if already selected
//			$this.addClass('is-checked');
			if ( !$this.hasClass('is-checked') ) {
				$this.parents('#options').find('.btn').removeClass('is-checked');
				$this.addClass('is-checked');
			}

			var selector = $this.attr('data-filter');
			var iso = new Isotope(projGrid, {
				itemSelector: '.item',
				filter: selector
			});
			return false;
		});

	});
});

