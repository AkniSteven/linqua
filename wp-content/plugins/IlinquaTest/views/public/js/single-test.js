requirejs([
    'jquery',
    'masonry.pkgd',
    'jquery.steps',
    'jquery.validate',

], function ($, Masonry) {

    'use strict';

    var FormControl = {
        init: function () {
            this.labelTop();
        },

        labelTop: function () {
            $('input, textarea').on('blur', function() {
                console.log('saxas');
                if ($(this).val() !== '') {
                    $(this).addClass('input--filled');
                } else {
                    $(this).removeClass('input--filled');
                }
            });
        }

    };
    FormControl.init();

    var PluginsInit = {
        init: function () {
            this.singleTest();
            this.publicationsGrid();
        },

        /* ========== Tests steps ========== */
        singleTest: function () {
            var steps = $(".test-holder").show();
            steps.steps({
                headerTag: ".pagination",
                bodyTag: ".question",
                transitionEffect: "fade",
                transitionEffectSpeed: 350,
                autoFocus: true,
                titleTemplate: "#title#",
                labels: {
                    next: 'Ответ',
                    finish: "Finish"
                }
            });

            AnswerBtnEvents();
            function AnswerBtnEvents() {
                /* ========== Check validation inputs ========== */
                $('.answer-button').on('click', function () {
                    var checkRadio = $(this).siblings('.answer-val').find('input:checked'),
                        checkCheckbox = $(this).siblings('.answer-val').find('input:checked'),
                        checkTextarea = $(this).siblings('.answer-val').find('textarea'),
                        answerBlock = $(this).siblings('.answer-val');

                    if (checkTextarea.val() !== '' && checkTextarea.length) {
                        steps.steps("next");
                    }
                    if (checkRadio.length || checkCheckbox.length) {
                        steps.steps("next");
                    } else {
                        answerBlock.addClass('error-inputs')
                    }
                });
                /* ========== END Check validation inputs  ========== */

                /* ========== Show finish tests page ======= */
                var lastBlock = $(".question").last().find('.answer-button');
                lastBlock.on('click', function () {
                    var checkRadio = $(this).siblings('.answer-val').find('input:checked'),
                        checkCheckbox = $(this).siblings('.answer-val').find('input:checked'),
                        checkTextarea = $(this).siblings('.answer-val').find('textarea'),
                        answerBlock = $(this).siblings('.answer-val');

                    if (checkTextarea.val() !== '' && checkTextarea.length) {
                        $('.single-test-page').addClass('js-show-finish-test');
                        $('body').scrollTop(0);
                    }
                    if (checkRadio.length || checkCheckbox.length) {
                        $('.single-test-page').addClass('js-show-finish-test');
                        $('body').scrollTop(0);
                    } else {
                        answerBlock.addClass('error-inputs')
                    }
                });
                /* ========== END Show finish page   ========== */
            }

            /* ========== Remove input error  ========== */
            RemoveErrorState();
            function RemoveErrorState() {
                $('.answer-val').on('click', function () {
                    if ($(this).find('input:checked')) {
                        $('.answer-val').removeClass('error-inputs');
                    }
                })
            }

            /* ========== END Remove input error   ========== */
        },
        /* ========== END Tests steps  ========== */

        /* ========== Publications grid ========== */
        publicationsGrid: function () {
            var elem = document.querySelector('.grid');
            var msnry = new Masonry(elem, {
                columnWidth: '.column-width',
                itemSelector: '.lp-article__tile',
                rowHeight: 110,
                percentPosition: false,
                transitionDuration: '0.4s',
                stagger: '0,03s',
                gutter: 40,
            });

            msnry.on('layoutComplete', function () {
                if ($(window).width() <= 1240) {
//					var elem = document.querySelector('.grid');
//
//					var msnry = new Masonry(elem, {
//						gutter: 20
//					});
                    console.log('small');
                } else {
                    console.log('big');
                }
            });
        }

        /* ========== END Publications grid  ========== */
    };
    PluginsInit.init();

});


