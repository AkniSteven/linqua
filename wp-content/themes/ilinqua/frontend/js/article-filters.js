requirejs([
	'jquery',
	'https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.0/isotope.pkgd.min.js',
	'https://npmcdn.com/isotope-fit-columns@1/fit-columns.js'
//	'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js',
], function ($, Isotope) {

	'use strict';

// init Isotope
	var iso = new Isotope('.grid', {
		itemSelector: '.lp-article__tile',
		masonry: {
			columnWidth: '.column-width',
			rowHeight: 110,
			percentPosition: false,
//			gutter: '.gutter-sizer'
			gutter: 40
	}
	});



	changeBigtilePosition();
	function changeBigtilePosition() {
	}

// filter functions
	var filterFns = {
		// show if number is greater than 50
		numberGreaterThan50: function (itemElem) {
			var number = itemElem.querySelector('.number').textContent;
			return parseInt(number, 10) > 50;
		},
		// show if name ends with -ium
		ium: function (itemElem) {
			var name = itemElem.querySelector('.name').textContent;
			return name.match(/ium$/);
		}
	};

// bind filter button click
	var filtersElem = document.querySelector('.filters-button-group');
	filtersElem.addEventListener('click', function (event) {
		var filterValue = event.target.getAttribute('data-filter');
		// use matching filter function
		filterValue = filterFns[filterValue] || filterValue;
		iso.arrange({filter: filterValue});
	});


	ActiveFilterButton();
	function ActiveFilterButton() {
		var filterButton = $('.lp-community__filter-item');

		filterButton.on('click', function () {
			$(this).addClass('is-checked');
			$(this).siblings('.lp-community__filter-item').removeClass('is-checked');
		})
	}

//	function radioButtonGroup(buttonGroup) {
//		buttonGroup.addEventListener('click', function (event) {
//			buttonGroup.querySelector('.is-checked').classList.remove('is-checked');
//			event.target.classList.add('is-checked');
//			console.log('csdcdsc');
//		});
//	}
//	radioButtonGroup();

});

















