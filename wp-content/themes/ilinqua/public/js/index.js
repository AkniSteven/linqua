requirejs([
	'jquery',
	'ScrollMagic',
	'animation.gsap',
	// 'TweenMax',
	// 'TimelineLite',
	// 'TimelineMax',
	// 'TweenLite',
	'debug.addIndicators'

], function ($, ScrollMagic) {

	'use strict';

	var controller = new ScrollMagic.Controller();

	var scene = new ScrollMagic.Scene({
		// triggerElement: ".price-block",
		offset: 10,
		duration: 1000

	})
	// .setClassToggle(".price-block-holder", "js-del-shadow")
	.setTween(".price-block-holder", 2, {css:{paddingLeft:"0", paddingRight:"0"}, ease:Power2.easeOut})
	.addTo(controller);

	new ScrollMagic.Scene({
		triggerElement: "header",
		offset: 1000,
		reverse: true
	})
		.setClassToggle(".price-block", "js-del-shadow") // add class toggle
		// .addIndicators() // add indicators (requires plugin)
		.addTo(controller);
});

