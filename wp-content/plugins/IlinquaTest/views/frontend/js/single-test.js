requirejs([
	'jquery',
	'jquery.steps',
	'jquery.validate',

], function ($) {

	'use strict';
	console.log('cdscsd');

	var PluginsInit = {
		init: function () {
			this.singleTest();
		},


		singleTest: function () {
			var steps = $(".test-holder");
			steps.steps({
				headerTag: ".pagination",
				bodyTag: ".question",
				transitionEffect: "slideLeft",
				autoFocus: true,
				titleTemplate: "#title#",
			});
		}
	};
	PluginsInit.init();
});


