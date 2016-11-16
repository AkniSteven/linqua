requirejs([
	'jquery',
	'ScrollMagic',
//	'masonry.pkgd',
	'swiper',
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
	function iosHeightFix() {

		function priceCellChangePosition() {
			var priceBlockCell = $('.price-block__tariff-cell'),
				priceBlockHolder = $('.price-block-wrapper');
			enquire
				.register("screen and (max-width : 768px)", {
					match: function priceCellChangePosition() {
						$('.language-banner').height($(window).height()/1 - 200);
//						$('.language-banner').height($(window).height()/1 - 200);
					},
					unmatch: function () {
//						alert('a')
						$('.language-banner').height($(window).height()/1 -200);
					}
				});
		}
		priceCellChangePosition();

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
//		function get_name_browser(){
//			// получаем данные userAgent
//			var ua = navigator.userAgent;
//			// с помощью регулярок проверяем наличие текста,
//			// соответствующие тому или иному браузеру
//			if (ua.search(/Chrome/) > 0) return 'Google Chrome';
//			if (ua.search(/Firefox/) > 0) return 'Firefox';
//			if (ua.search(/Opera/) > 0) return 'Opera';
//			if (ua.search(/Safari/) > 0) return 'Safari';
//			if (ua.search(/MSIE/) > 0) return 'Internet Explorer';
//			// условий может быть и больше.
//			// сейчас сделаны проверки только
//			// для популярных браузеров
//			return 'Не определен';
//		}
//
//// пример использования
//		var browser = get_name_browser();
//		alert(browser);
////
		var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
		var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
		var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
		var is_safari = navigator.userAgent.indexOf("Safari") > -1;
		var is_Opera = navigator.userAgent.indexOf("Presto") > -1;
		if ((is_chrome)&&(is_safari)) {is_safari=false;}

//		if (is_safari) alert('Sacdscfari');
//		if (is_chrome) alert('Chrome');
//		alert(navigator.userAgent);
////		$(window).resize(function () {
////			if (isiPad > -1) {
////				$('.language-banner').height($(window).height() / 1 - vHeight);
////			}
////		});
	}
//
	iosHeightFix();
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
						centeredSlides: false,
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
					}
				},
				unmatch: function () {
					if (priceBlockCell.length > 2) {
						priceBlockHolder.removeClass('js-restructuring-cells');
					} else {
					}
				}
			});
	}

	priceCellChangePosition();
	/* ========== END Price cell change position ========== */

	/* ========== Article filters ========== */
	/*var ArticleFilters = (function () {
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

				/!* ========== big article item  ========== *!/
				/!*				for(i = 0; i < JSONdata.length; i ++) {
				 currentItem = JSONdata[i];
				 productHtml = "<figure class=\"lp-article__tile--big\" style=\"background-image: url('http://cdn.head-fi.org/6/6d/6d51bd27_moto.jpeg')\">" +
				 "<figcaption class=\"article-tile__description\">" +
				 "<a href='#' class=\"tile-description__btn btn grey\">18 ОКТЯБРЯ</a>" +
				 "<h4 class=\"tile-description__title\">Кино-клуб</h4>" +
				 "<span class=\"tile-description__subtitle\">Будем ахать и охать. Моральные и этические принципы оставим дома </span>" +
				 "</figcaption>" +
				 "</figure>";
				 productsHtml.push(productHtml);
				 }*!/
				/!* ========== END big article item   ========== *!/

				/!* ========== small article item ========== *!/
				for (i = 0; i < JSONdata.length; i++) {
					currentItem = JSONdata[i];
					productHtml = "<figure class=\"lp-article__tile--middle\">" +
						"<div class=\"article-tile__img\" style=\"background-image: url('http://cdn.head-fi.org/6/6d/6d51bd27_moto.jpeg')\"></div>" +
						"<figcaption class=\"article-tile__description item\">10 заповедей школы iLingua</figcaption>" +
						"</figure>";
					productsHtml.push(productHtml);
				}
				/!* ========== END small article item  ========== *!/

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
	ArticleFilters.init();*/
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
	/*masonryInit();
	function masonryInit() {
		var elem = document.querySelector('.lp-article__holder');
		var msnry = new Masonry(elem, {
			itemSelector: 'figure',
			columnWidth: 293,
			gutter: 40,
		});

		/!* ========== Infinity scroll ========== *!/
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
		ias.extension(new IASSpinnerExtension());
		ias.extension(new IASTriggerExtension({offset: 4}));
		ias.extension(new IASNoneLeftExtension({text: "You reached the end"}));
		/!* ========== END Infinity scroll  ========== *!/
	}*/

	/* ========== END Masonry init  ========== */

});

