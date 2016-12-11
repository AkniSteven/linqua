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

			/* ========== Check validation inputs ========== */
			$('.answer-button').on('click', function () {
				var checkRadio = $(this).siblings('.answer-val').find('#radio-some-id1');
				var checkCheckbox = $(this).siblings('.answer-val').find('#checkbox-some-id1');
				var answerBlock = $(this).siblings('.answer-val');
				if (checkRadio.prop('checked') || checkCheckbox.prop('checked')) {
					console.log('ok');
					steps.steps("next");
				} else {
					console.log('fuck');
					answerBlock.addClass('error-inputs')
				}
			});
			/* ========== END Check validation inputs  ========== */
		},
		/* ========== END Tests steps  ========== */

		/* ========== Publications grid ========== */
		publicationsGrid: function () {
			var elem = document.querySelector('.grid');
			var msnry = new Masonry( elem, {
				itemSelector: '.lp-article__tile',
				columnWidth: 50,
				rowHeight: 110,
				percentPosition: true,
				transitionDuration: '0.4s',
				stagger: '0,03s',
				gutter: 40,
			});
		}
		/* ========== END Publications grid  ========== */
	};
	PluginsInit.init();

	var singleTestPage = {
		init: function () {
			this.showFinishTest();
		},

		/* ========== Show finish tests page ======= */
		showFinishTest: function () {
			var lastBlock = $(".question").last().find('.answer-button');
			lastBlock.on('click', function () {
				$('.single-test-page').addClass('js-show-finish-test');
			});
		}
		/* ========== END Show finish page   ========== */
	};
	singleTestPage.init();
});


