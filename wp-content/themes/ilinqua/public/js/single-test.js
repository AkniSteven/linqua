requirejs([
	'jquery',
	'jquery.steps',
	'jquery.validate',

], function ($) {

	'use strict';

	var PluginsInit = {
		init: function () {
			this.testSteps();
		},


		testSteps: function () {
			var steps = $(".steps-holder");
			steps.steps({
				headerTag: ".pagination",
				bodyTag: ".single-test__step",
				transitionEffect: "slideLeft",
				autoFocus: true,
				titleTemplate: "#title#",
			});
		}
	};
	PluginsInit.init();
});

