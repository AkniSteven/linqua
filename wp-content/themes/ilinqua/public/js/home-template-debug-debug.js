requirejs([
    'jquery',
    'ScrollMagic',
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
                .register("screen and (max-width : 640px)", {
                    match: function priceCellChangePosition() {
                        $('.language-banner').height($(window).height());
                    },
                    unmatch: function () {
                        $('.language-banner').height($(window).height());
                    }
                });
        }

        priceCellChangePosition();

        var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
        var is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
        var is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
        var is_safari = navigator.userAgent.indexOf("Safari") > -1;
        var is_Opera = navigator.userAgent.indexOf("Presto") > -1;
        if ((is_chrome) && (is_safari)) {
            is_safari = false;
        }
    }

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

});

