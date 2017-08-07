requirejs([
	'jquery'

], function ($) {

	'use strict';
	let indexPage = {
		init: function () {
			this.burgerPopupOpen();
		},
		/* ========== Burger popup open ========== */
		burgerPopupOpen: function () {
			$('.burger-menu').on('click', function () {
				$(this).parents('body').addClass('burger-popup--open');
			});
			/* ========== END Burger popup open  ========== */

			/* ========== Burger popup close ========== */
			$('.burger-popup__close-popup').on('click', function () {
				$(this).parents('body').removeClass('burger-popup--open');
				console.log('sdvdfsvdfbv');
			});
			/* ========== END Burger popup close  ========== */

//			$(document).ready(function(){
//				$('.burger-menu').click(function(){
//					$(this).toggleClass('open');
//				});
//			});
		}
	};
	indexPage.init();
});

