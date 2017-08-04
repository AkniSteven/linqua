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
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_LEFT
            },
            styles: [{
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
            }, {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ffffff"}, {"lightness": 17}]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{"color": "#ffffff"}, {"lightness": 18}]
            }, {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{"color": "#ffffff"}, {"lightness": 16}]
            }, {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{"color": "#dedede"}, {"lightness": 21}]
            }, {
                "elementType": "labels.text.stroke",
                "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
            }, {
                "elementType": "labels.text.fill",
                "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
            }, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#fefefe"}, {"lightness": 20}]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
            }]
        };

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var markerImage = new google.maps.MarkerImage(
            '/wp-content/themes/ilinqua/public/images/pin_large_black.png',
            new google.maps.Size(60, 60),
            new google.maps.Point(0, 0),
            new google.maps.Point(0, 44)
        );

        var marker = new google.maps.Marker({
            icon: markerImage,
            position: myLatlng,
            map: map,
            zIndex: 99999999
        });

        marker.setMap(map);
    }
});

