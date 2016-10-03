requirejs([
	'jquery',
	'ScrollMagic',
	'animation.gsap',
	'debug.addIndicators'

], function ($, ScrollMagic) {

	'use strict';

	var controller = new ScrollMagic.Controller();

	var scene = new ScrollMagic.Scene({
		offset: 10,
		duration: 1000

	})
	.setTween(".price-block-holder", 2, {css:{paddingLeft:"0", paddingRight:"0"}, ease:Power2.easeOut})
	.addTo(controller);

	new ScrollMagic.Scene({
		triggerElement: "header",
		offset: 900,
		reverse: true
	})

	.setClassToggle(".price-block", "js-del-shadow") // add class toggle
	.addTo(controller);

});

