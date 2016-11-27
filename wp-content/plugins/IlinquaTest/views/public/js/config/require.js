(function () {
	'use strict';
	requirejs.config({
		"baseUrl": '/wp-content/plugins/IlinquaTest/views/public/js',
		"waitSeconds": 30,
		"paths": {},
		"map": {
			"*": {
				twig: 'config/twig',
				'vue': 'config/vue'
			},
			"config/twig": {
				'twig': 'twig'
			},
			"config/vue": {
				'vue': 'vue'
			}
		},
	});
}());
