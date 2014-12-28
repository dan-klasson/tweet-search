@extends('layouts.master')

@section('title')
Tweets for {{ $city }}
@stop

@section('head')
<style type="text/css">
html, body, #map-canvas { 
	height: 100%; 
	width: 100%; 
	margin: 0px; 
	padding 0px; 
}
.list-group {
	position: absolute;
	bottom: 20px;
	left: 450px;
	width: 300px;
	display: none;
	z-index: 5;
}
.header-text {
	position: absolute;
	z-index: 5;
	top: 0;
	padding: 20px;
	left: 35%;
	color: blue;
	font-size: 30px;
}
#history {
	display: none;
}
.row {
	position: absolute;
	bottom: 0;
	z-index: 5;
	width: 100%;
	margin: 10px; 
}
</style>

<script type="text/javascript">

jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);

	var url = '{{ url() }}'; // current URL

	// Blue overlay text on map
	var headerText = 'TWEETS ABOUT ' + '{{ $city }}'.toUpperCase();
	$(".header-text").html(headerText);

	// Close history menu
	$('.list-group').on('click', '#close-history', function (event) {
		$( ".list-group" ).hide();
	});

	// show the history button if the user has prior searches
	if(typeof $.cookie("searches") !== 'undefined')
	{
		$('#history').show();
	}

	// Populate history menu
	$( "#history" ).on('click', function(e) {
		var cookies = $.cookie("searches");
		cookies = cookies.split(",");
		$(".list-group").html('');
		$(".list-group").append('<a href="#" class="list-group-item" id="close-history">&lt; BACK TO THE TWEETS</a>');
		$.each( cookies, function( key, city ) {
			$(".list-group").append('<a href="' + url + '/' + city.toLowerCase() + '" class="list-group-item">' + city + '</a>');
		});
		$( ".list-group" ).show();
	});

	// Set cookie and forward user to new URL
	$( "form" ).submit(function(e) {
		var city = $("input[name='city']").val();

		// make first letter uppercase
		city = city.charAt(0).toUpperCase() + city.slice(1);

		var cookies = $.cookie("searches");

		if(typeof cookies !== 'undefined')
		{
			cookies = cookies.split(",");
			if($.inArray(city, cookies) == -1)
			{
				cookies.push(city);
			}
		}
		else
		{
			cookies = city;
		}

		$.cookie("searches", cookies);
		window.location.replace(url + '/' + city.toLowerCase());
		e.preventDefault();
	});

});

function initialize() {
	var map;
	var position;
	var markers = [];
	var infoWindowContent = [];
	var bounds = new google.maps.LatLngBounds();
	var myLatlng = new google.maps.LatLng({{ $coordinates['lat'] }},{{ $coordinates['lng']}});
	var mapOptions = {
		zoom: 12,
		center: myLatlng,
	};

	// Display a map on the page
	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

	// Pouplate the markers
	var infoWindow = new google.maps.InfoWindow(), marker, i;
	infoWindowContent.push('<div class="info_content">');
	@foreach($contents as $content)
		markers.push([
			'{{ $content["username"]}}', 
			'{{ $content["geo_lat"] }}', 
			'{{ $content["geo_lng"] }}', 
			'{{ $content["profile_pic"] }}'
		]);

		infoWindowContent.push([
			'<div class="info_content">' +
			'<h3>{{ $content["username"]}}</h3>' +
			'<p>{{ $content["tweet"]}}</p><p><i>{{ $content["created_at"]}}' + '</div>'
		]);
	@endforeach

	// Display the multiple markers on the map
	var infoWindow = new google.maps.InfoWindow(), marker, i;

	// Loop through our array of markers & place each one on the map
	for( i = 0; i < markers.length; i++ ) {
		var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
		bounds.extend(position);
		marker = new google.maps.Marker({
			position: position,
			map: map,
			title: markers[i][0],
			icon: markers[i][3],
		});

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));
    }
}
</script>


@stop


@section('content')

<div id="map-canvas"></div>

<div class="header-text"></div>

<div class="list-group"></div>

@include('search_form')

@stop
