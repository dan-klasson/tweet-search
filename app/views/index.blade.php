@extends('layouts.master')

@section('head')
    <style type="text/css">
      html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key={{ getenv('GOOGLE_MAPS_API_KEY') }}">
    </script>
    <script type="text/javascript">
    function initialize()
    {
/*
        var myLatlng = new google.maps.LatLng({{ $coordinates['lat'] }},{{ $coordinates['lng']}});
        var mapOptions = {
            zoom: 8,
            center: myLatlng
         };

          var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);


 var imageBounds = new google.maps.LatLngBounds(myLatlng, myLatlng);
  historicalOverlay = new google.maps.GroundOverlay(
      'http://pbs.twimg.com/profile_images/539811188402442240/BreorRyD_normal.jpeg',
      imageBounds);
  historicalOverlay.setMap(map);

*/
  var newark = new google.maps.LatLng(40.740, -74.18);
  var imageBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(40.712216, -74.22655),
      new google.maps.LatLng(40.733941, -74.20544));

  var mapOptions = {
    zoom: 13,
    center: newark
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  historicalOverlay = new google.maps.GroundOverlay(
      'http://pbs.twimg.com/profile_images/539811188402442240/BreorRyD_normal.jpeg',
      imageBounds);
  historicalOverlay.setMap(map);

      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>

@stop


@section('content')
 <div id="map-canvas"></div>
@stop
