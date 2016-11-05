requirejs([
	'jquery',
	'ScrollMagic',
	'masonry.pkgd',
	'swiper',
//	'http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.3/vue-resource.min.js',
	'animation.gsap',
	'TweenMax',
	'debug.addIndicators',
	'enquire',
	'jquery-ias.min',
	'spinner',
	'trigger',
	'noneleft',


], function ($, ScrollMagic, Masonry, Swiper) {

	'use strict';

	/* ========== End ios trouble fix ========== */
//	function iosHeightFix() {
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
	/* ========== END End ios trouble fix  ========== */

	/* ========== Scroll-responsive price-block ========== */
	var controller = new ScrollMagic.Controller();

	new ScrollMagic.Scene({
		offset: 10,
		duration: 1000
	})
		.setTween(".full", 2, {css: {width: "100vw"}, ease: Power2.easeOut})
		.addTo(controller);

	new ScrollMagic.Scene({
		/*triggerElement: "header",*/
		offset: 250,
		reverse: true
	})
		.setClassToggle(".full", "js-del-shadow") /* add class toggle*/
		.addTo(controller);

	new ScrollMagic.Scene({
		offset: 10,
		reverse: true
	})
		.setClassToggle(".price-block", "js-del-status") // add class toggle
		.addTo(controller);
	/* ========== END Scroll-responsive price-block  ========== */

	/* ========== Will build slider ========== */
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
	/* ========== END Will build slider ========== */

	/* ========== Price cell change position ========== */
	function priceCellChangePosition() {
		var priceBlockCell = $('.price-block__tariff-cell'),
			priceBlockHolder = $('.price-block-wrapper');
		enquire
			.register("screen and (max-width : 768px)", {
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
	/* ========== END Price cell change position ========== */

	/* ========== Article filters ========== */
	var ArticleFilters = (function () {
		var
			filter = document.querySelectorAll(".filter"),
			productList = document.getElementById("article-list"),
			jsonTOhtml = function (JSONdata) {
				var i,
					currentItem,
					finalHtml,
					productHtml = "",
					productsHtml = [];

				productsHtml.push("<div class=\"lp-article__holder\">");

				/* ========== big article item  ========== */
				/*				for(i = 0; i < JSONdata.length; i ++) {
				 currentItem = JSONdata[i];
				 productHtml = "<figure class=\"lp-article__tile--big\" style=\"background-image: url('http://cdn.head-fi.org/6/6d/6d51bd27_moto.jpeg')\">" +
				 "<figcaption class=\"article-tile__description\">" +
				 "<a href='#' class=\"tile-description__btn btn grey\">18 ОКТЯБРЯ</a>" +
				 "<h4 class=\"tile-description__title\">Кино-клуб</h4>" +
				 "<span class=\"tile-description__subtitle\">Будем ахать и охать. Моральные и этические принципы оставим дома </span>" +
				 "</figcaption>" +
				 "</figure>";
				 productsHtml.push(productHtml);
				 }*/
				/* ========== END big article item   ========== */

				/* ========== small article item ========== */
				for (i = 0; i < JSONdata.length; i++) {
					currentItem = JSONdata[i];
					productHtml = "<figure class=\"lp-article__tile--middle\">" +
						"<div class=\"article-tile__img\" style=\"background-image: url('http://cdn.head-fi.org/6/6d/6d51bd27_moto.jpeg')\"></div>" +
						"<figcaption class=\"article-tile__description item\">10 заповедей школы iLingua</figcaption>" +
						"</figure>";
					productsHtml.push(productHtml);
				}
				/* ========== END small article item  ========== */

				productsHtml.push("</div>");

				finalHtml = productsHtml.join("\n");

				addHTMLtoDOM(finalHtml);
			},

			addHTMLtoDOM = function (html) {
				var exisitingProducts = productList.querySelectorAll(".lp-article__holder");

				if (exisitingProducts.length !== 0) {
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
			};
		return {
			init: init
		};
	}());
	ArticleFilters.init();
	/* ========== END Article filters  ========== */

	/* ========== Test section ========== */
	/*$('a').on('click', function () {
	 $.ajax({
	 url: "wp-content/themes/ilinqua/vi/test.html",
	 cache: false,
	 success: function(html){
	 $("#results").append(html);
	 }
	 });
	 });*/
	/* ========== END Test section  ========== */

	/* ========== Masonry init ========== */
	masonryInit();
	function masonryInit() {
		var elem = document.querySelector('.lp-article__holder');
		var msnry = new Masonry(elem, {
			itemSelector: 'figure',
			columnWidth: 293,
			gutter: 40,
//			percentPosition: true
		});

		/* ========== Infinity scroll ========== */
		var ias = jQuery.ias({
			container: '#article-list',
			item: 'figure',
			next: '.lp-article__next',
			delay: 100
		});
		ias.on('render', function (items) {
			$(items).css({opacity: 0});
		});

		ias.on('rendered', function (items) {
			msnry.appended(items);
		});
// Add a loader image which is displayed during loading
		ias.extension(new IASSpinnerExtension());

// Add a link after page 2 which has to be clicked to load the next page
		ias.extension(new IASTriggerExtension({offset: 4}));

// Add a text when there are no more pages left to load
		ias.extension(new IASNoneLeftExtension({text: "You reached the end"}));
		/* ========== END Infinity scroll  ========== */
	}

	/* ========== END Masonry init  ========== */

});

