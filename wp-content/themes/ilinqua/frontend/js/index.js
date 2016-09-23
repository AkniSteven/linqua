requirejs([
	'jquery'
], function ($) {

	'use strict';

	/*init plugins*/

	var initPlugins = {
		init: function () {
			// this.selectInit();
		},

	};
	initPlugins.init();

	/* end init plugins*/

	// additional functions for plugins
	var additionalForPlugins = {
		init: function () {
			this.selectVectorRotate();
		},

		selectVectorRotate: function () {
			var filterTitle = $('.filter-item .title');

			filterTitle.click(function () {
				var holder = $('.holder'),
					$filterTitle = $(this);

				$filterTitle.parents('.filter-item').siblings().removeClass('active');
				$filterTitle.parents('.filter-item').toggleClass('active');
			});
		}
	};
	additionalForPlugins.init();
	// end additional functions for plugins

});

