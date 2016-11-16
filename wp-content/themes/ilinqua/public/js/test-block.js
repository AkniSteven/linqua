requirejs([
	'jquery',
//	'https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.0/isotope.pkgd.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js',
//	'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.1.1/masonry.pkgd.js',
	'masonry.pkgd',
	'https://npmcdn.com/isotope-layout@3/dist/isotope.pkgd.js'
], function ($, Isotope) {

	'use strict';

	// external js: isotope.pkgd.js

// init Isotope
	var iso = new Isotope( '.grid', {
		itemSelector: '.element-item',
		layoutMode: 'fitRows'
	});

// filter functions
	var filterFns = {
		// show if number is greater than 50
		numberGreaterThan50: function( itemElem ) {
			var number = itemElem.querySelector('.number').textContent;
			return parseInt( number, 10 ) > 50;
		},
		// show if name ends with -ium
		ium: function( itemElem ) {
			var name = itemElem.querySelector('.name').textContent;
			return name.match( /ium$/ );
		}
	};

// bind filter button click
	var filtersElem = document.querySelector('.filters-button-group');
	filtersElem.addEventListener( 'click', function( event ) {
		// only work with buttons
		if ( !matchesSelector( event.target, 'button' ) ) {
			return;
		}
		var filterValue = event.target.getAttribute('data-filter');
		// use matching filter function
		filterValue = filterFns[ filterValue ] || filterValue;
		iso.arrange({ filter: filterValue });
	});

// change is-checked class on buttons
//	var buttonGroups = document.querySelectorAll('.button-group');
//	for ( var i=0, len = buttonGroups.length; i < len; i++ ) {
//		var buttonGroup = buttonGroups[i];
//		radioButtonGroup( buttonGroup );
//	}

	function radioButtonGroup( buttonGroup ) {
		buttonGroup.addEventListener( 'click', function( event ) {
			// only work with buttons
			if ( !matchesSelector( event.target, 'button' ) ) {
				return;
			}
			buttonGroup.querySelector('.is-checked').classList.remove('is-checked');
			event.target.classList.add('is-checked');
		});
	}

});

















