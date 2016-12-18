requirejs([
	'jquery'

], function ($) {

	'use strict';
	var indexPage = {
		init: function () {
			this.burgerPopupOpen();
		},
		/* ========== Burger popup open ========== */
		burgerPopupOpen: function () {
			$('.burger-menu').on('click', function (e) {
				e.stopPropagation();
				$(this).parents('body').addClass('burger-popup--open');
			});
		/* ========== END Burger popup open  ========== */

		/* ========== Burger popup close ========== */
			$('.burger-popup__close-popup').on('click', function () {
				$(this).parents('body').removeClass('burger-popup--open');
			});
		/* ========== END Burger popup close  ========== */
		}
	};
	indexPage.init();
});

