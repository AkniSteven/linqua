requirejs([
	'jquery',
	'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js'
], function ($, Masonry) {

	'use strict';

// init Isotope
//	var iso = new Isotope('.grid', {
//		itemSelector: '.lp-article__tile',
//		masonry: {
//			columnWidth: 200,
//			rowHeight: 110,
////			percentPosition: false,
////			gutter: '.gutter-sizer'
//			gutter: 40
//	}
//	});

	var elem = document.querySelector('.article-more__list');
	var msnry = new Masonry(elem, {
		columnWidth: '.column-width--article',
		rowHeight: 110,
		percentPosition: false,
		gutter: 40
	});

});

















