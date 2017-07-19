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

], function ($, ScrollMagic, Swiper) {

    'use strict';

    /* ========== End ios trouble fix ========== */
    function iosHeightFix() {

        function priceCellChangePosition() {
            var priceBlockCell = $('.price-block__tariff-cell'),
                priceBlockHolder = $('.price-block-wrapper');
            enquire
                .register("screen and (max-width : 768px)", {
                    match: function priceCellChangePosition() {
                        $('.language-banner').height($(window).height() / 1 - 200);
                    },
                    unmatch: function () {
                        $('.language-banner').height($(window).height() / 1 - 200);
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
        if ((is_chrome) && (is_safari)) {
            is_safari = false;
        }

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
    function profileNavSwiper(e) {
        enquire
            .register("screen and (max-width : 1024px)", {
                match: function profileNavSwiper(e) {
                    var profileNav = new Swiper('.swiper-container', {
                        slidesPerView: 'auto',
                        centeredSlides: false,
                        grabCursor: true
                    });
                },
                unmatch: function () {
                    e.destroy();
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

