requirejs([
	'jquery',
	'https://maps.googleapis.com/maps/api/js?key=AIzaSyD6K7XPdLvol3PuqgcuQFtEzw0I1oTF42w&callback=initMap',
	'enquire',

], function ($) {

	'use strict';
	initMap();
	function initMap() {
		var myLatlng = new google.maps.LatLng(49.996021, 36.229306);
		var center = new google.maps.LatLng(49.991999, 36.190040);
		var mapOptions = {
			zoom: 16,
			scrollwheel: false,
//                    disableDefaultUI: false,
			mapTypeControl: false,
//                    scaleControl: false,
			zoomControl: false,
			streetViewControl: false,
			center: myLatlng,
			backgroundColor: 'none',
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			},
			styles:
				[
					{
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#0b75ec"
							}
						]
					},
					{
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#07499a"
							}
						]
					},
					{
						"elementType": "labels.text.stroke",
						"stylers": [
							{
								"color": "#07499a"
							}
						]
					},
					{
						"featureType": "administrative",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "administrative.country",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "administrative.country",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "administrative.land_parcel",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "administrative.locality",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "labels.text.fill",
						"stylers": [
							{"saturation": 100}, {"color": "#074b9d"}
						]
					},{
						"featureType": "poi",
						"elementType": "labels.text.stroke",
						"stylers": [
							{"color": "#0b77f9"}, {"lightness": 1}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#0a6ee6"
							}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "labels.text.fill",
						"stylers": [
							{"color": "#0b77f9"}, {"lightness": 1}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "labels.text.stroke",
						"stylers": [
							{"color": "#0b77f9"}, {"lightness": 1}
						]
					},
					{
						"featureType": "road",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#0b78fc"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.text.fill",
						"stylers": [
							{"saturation": 100}, {"color": "#074b9d"}
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.text.stroke",
						"stylers": [
							{"color": "#0b77f9"}, {"lightness": 1}
						]
					},
					{
						"featureType": "road.arterial",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#0c7aff"
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#0c7aff"
							}
						]
					},
					{
						"featureType": "road.highway.controlled_access",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#07499a"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#fff"
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#0c7aff"
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#074999"
							}
						]
					}
				]

		};

		var map = new google.maps.Map(document.getElementById("map"), mapOptions);

		var markerImage = new google.maps.MarkerImage(
			'/wp-content/themes/ilinqua/public/images/pin.png',
			new google.maps.Size(60, 60),
			new google.maps.Point(0, 0),
			new google.maps.Point(0, 44)
		);

		var marker = new google.maps.Marker({
			icon: markerImage,
			position: myLatlng,
			map: map,
			zIndex: 9999999999
		});

		marker.setMap(map);
	}
});

