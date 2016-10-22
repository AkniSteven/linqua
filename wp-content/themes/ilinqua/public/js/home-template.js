requirejs([
	'jquery',
	'ScrollMagic',
	'animation.gsap',
	'TweenMax',
	'debug.addIndicators',
	'enquire'
//	'swiper'

], function ($, ScrollMagic) {

	'use strict';

	/*ios trouble fix*/

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

	/* end ios trouble fix*/

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

	/*will build slider*/

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

	/* end will build slider*/

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

	/*filters*/
	var PRODUCTLIST = (function () {

		var
			filter = document.querySelectorAll(".filter"),
			productList = document.getElementById("article-list"),
			jsonTOhtml = function (JSONdata) {
				var i,
					productsInHtml,
					currentItem,
					finalHtml,
					productHtml = "",
					productsHtml = [];

				productsHtml.push("<ul class=\"article-list__holder\">");

				for(i = 0; i < JSONdata.length; i ++) {
					currentItem = JSONdata[i];
					productHtml = "<li class=\"" + currentItem.category + "\"><a href='" + currentItem.url + "'>" + currentItem.name
						+ "</a> - <span>Price: " + currentItem.price + "</span>";
					productsHtml.push(productHtml);
				}

				productsHtml.push("</ul>");

				finalHtml = productsHtml.join("\n");

				addHTMLtoDOM(finalHtml);
			},

			addHTMLtoDOM = function (html) {
				var exisitingProducts = productList.querySelectorAll(".article-list__holder");

				if (exisitingProducts.length !== 0 ) {
					exisitingProducts[0].parentNode.removeChild(exisitingProducts[0]);
				}
				productList.insertAdjacentHTML("afterbegin", html);
			},

			callAjax = function (event) {

				var
					category = event.target.getAttribute("data-category");


				$.ajax({
					url: "http://staff.city.ac.uk/~sbbh718/api/products-list/products.php?callback=&category=" + category,
					dataType: "JSONP",
					success: function (data) {
						jsonTOhtml(data.products);
					}
				});

			},

			init = function () {
				// event handler here for all filter
				// start with 4 handlers and improve with bubbling

				filter[0].addEventListener(
					"click",
					callAjax,
					false
				);

				filter[1].addEventListener(
					"click",
					callAjax,
					false
				);

				filter[2].addEventListener(
					"click",
					callAjax,
					false
				);

				filter[3].addEventListener(
					"click",
					callAjax,
					false
				);

				filter[4].addEventListener(
					"click",
					callAjax,
					false
				);

			};

		return {
			init: init
		};

	}());

	PRODUCTLIST.init();



	/* end filters*/



});

