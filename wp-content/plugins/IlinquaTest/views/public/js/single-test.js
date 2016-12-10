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
			$('.answer-button').on('click', function () {
				steps.steps("next");
			});
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
				gutter: 40,
			});

		}
		/* ========== END Publications grid  ========== */
	};
	PluginsInit.init();
});


