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
		.setTween(".price-block-holder", 2, {css:{paddingLeft:"0", paddingRight:"0"}, ease:Power2.easeOut})
		// .addIndicators({name: "2 (duration: 300)"}) // add indicators (requires plugin)
		.addTo(controller);

});

