"use strict";


function googleMap () {
  if ($('.google-map').length) {
    $('.google-map').each(function () {
      // getting options from html 
      var Self = $(this);
      var mapName = Self.attr('id');
      var mapLat = Self.data('map-lat');
      var mapLng = Self.data('map-lng');
      var iconPath = Self.data('icon-path');
      var mapZoom = Self.data('map-zoom');
      var mapTitle = Self.data('map-title');


      var styles = [
				    {
				        "featureType": "administrative",
				        "elementType": "labels.text.fill",
				        "stylers": [
				            {
				                "color": "#444444"
				            }
				        ]
				    },
				    {
				        "featureType": "landscape",
				        "elementType": "all",
				        "stylers": [
				            {
				                "color": "#f2f2f2"
				            }
				        ]
				    },
				    {
				        "featureType": "poi",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "road",
				        "elementType": "all",
				        "stylers": [
				            {
				                "saturation": -100
				            },
				            {
				                "lightness": 45
				            }
				        ]
				    },
				    {
				        "featureType": "road.highway",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "simplified"
				            }
				        ]
				    },
				    {
				        "featureType": "road.arterial",
				        "elementType": "labels.icon",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "transit",
				        "elementType": "all",
				        "stylers": [
				            {
				                "visibility": "off"
				            }
				        ]
				    },
				    {
				        "featureType": "water",
				        "elementType": "all",
				        "stylers": [
				            {
				                "color": "#8fc941"
				            },
				            {
				                "visibility": "on"
				            }
				        ]
				    }
				]


      // if zoom not defined the zoom value will be 15;
      if (!mapZoom) {
        var mapZoom = 12;
      };
      // init map
      var map;
      map = new GMaps({
          div: '#'+mapName,
          scrollwheel: false,
          lat: mapLat,
          lng: mapLng,
          styles: styles,
          zoom: mapZoom
      });
      // if icon path setted then show marker
      if(iconPath) {
        
        map.addMarker({
            icon: 'images/logo/map.png',
            lat: 40.925372,
              lng: -74.276544,
              title: 'Legal Station Main Office',
              infoWindow: {
            content: '<h6>North Parchrtome Steet</h6> <p>Gazipur,Dhaka</p>'
          }
        });
        map.addMarker({
            icon: 'images/logo/map.png',
            lat: 40.929399,
              lng: -74.430091,
              title: 'Legal Station Tongi Branch',
              infoWindow: {
            content: '<h6>Raibow Manor California</h6> <p>Tongi,Dhaka</p>'
          }
        });
        map.addMarker({
            icon: 'images/logo/map.png',
            lat: 40.892321,
              lng: -74.477377,
              title: 'Legal Station Nikunjo Branch',
              infoWindow: {
            content: '<h6>17 Thorpe Close Notting</h6> <p>Nikunjo,Dhaka</p>'
          }
        });
        map.addMarker({
            icon: 'images/logo/map.png',
            lat: 40.935654,
              lng: -74.186256,
              title: 'Office Under Construction',
              infoWindow: {
            content: '<h6>Longkloof Studio</h6> <p>Banani,Dhaka</p>'
          }
        });
      }
    });  
  };
}


// Dom Ready Function
jQuery(document).on('ready', function () {
	(function ($) {
		// add your functions
		googleMap();
	})(jQuery);
});