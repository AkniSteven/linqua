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

<<<<<<< HEAD
	var elem = document.querySelector('.article-more__list');
=======
	var elem = document.querySelector('.grid');
>>>>>>> 4ff3d11a8dbfae2e1ae3edce00782ffcd33572e5
	var msnry = new Masonry(elem, {
		columnWidth: '.column-width--article',
		rowHeight: 110,
		percentPosition: false,
		gutter: 40
	});

});

















