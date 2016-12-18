requirejs([
	'jquery',
	'masonry.pkgd',
	'jquery.steps',
	'jquery.validate',

], function ($, Masonry) {

	'use strict';

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
					finish: "Finish",
				},
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
					}
					if (checkRadio.length || checkCheckbox.length) {
						$('.single-test-page').addClass('js-show-finish-test');
					} else {
						answerBlock.addClass('error-inputs')
					}
				});
				/* ========== END Show finish page   ========== */
			}

			/* ========== Remove input error  ========== */
			RemoveErrorState();
			function RemoveErrorState(){
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
			var lastBlock = $(".question").last().find('.answer-button');
			var elem = document.querySelector('.grid');
			var msnry = new Masonry(elem, {
				itemSelector: '.lp-article__tile',
				columnWidth: 50,
				rowHeight: 110,
				percentPosition: false,
				transitionDuration: '0.4s',
				stagger: '0,03s',
				gutter: 40,
			});

			lastBlock.on('click', function () {
//				elem.masonry('layout');
			});
		},
		/* ========== END Publications grid  ========== */
	};
	PluginsInit.init();
});


