@extends('layout.app')

@section('title')
VGN:{{ $list->Project_name }} Live Direction
@endsection

@section('description')
    <META NAME="Subject" CONTENT="{{ $list->Project_name }} Live Direction">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">


@endsection

@section('keyword')
   
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    #about li.collection-item p {
      line-height: 24px;
    font-size: 14px;
    color: #727272;
    }
    #about li.collection-item h6 {
      font-size: 13px;
    }


    #about ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    background-color: #eee;
    font-size: 12px;
    color: #727272;
    text-transform: uppercase;
    border-radius: 5px;
}

/* Display list items side by side */
#about ul.breadcrumb li {
    display: inline;
}

/* Add a slash symbol (/) before/behind each list item */
#about ul.breadcrumb li+li:before {
    padding: 8px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
#about ul.breadcrumb li a {
    text-decoration: none;
}

/* Add a color on mouse-over */
#about ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}

.bread .about-inner {
  margin: 52px 0px 10px 0px
}

.keypeople, .coreteam-inner .keypeople p{
  text-align: center;
  text-transform: uppercase;
}
.keypeople h3 {
      color: #727272;
      text-transform: uppercase;
}

.key .coreteam-inner .card-header {
  min-height: 240px;
    max-height: 240p
}

.key .coreteam-inner .card {
  width: 250px;
}
 	#map {
        width: 50%;
      }
      #right-panel{
      	overflow: auto;
      }

.gm-style-iw{
	color: #000;
    font-weight: bold;
}



    </style>
     <!--Start of vgn developers Zendesk Chat Script-->

<!--End of vgn developers  Zendesk Chat Script-->
@if($latitude == 0)
<script> 
    alert('No Data Available');
window.location.href ='{{ url()->full() }}';</script>
@endif
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist">
      

        
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-12" style="margin-top: 12px;">
              <div class="person-about">
               

			<div class="row">
            <div id="gmap" style="height:600px;" ></div>
  			
				</div>
              </div>

             </div>
            <!-- about me description -->

            <!-- about me image -->

           
            <!-- about me info -->

          </div>
        </div>
      
      <!-- .container end -->
      
    </section>
    <!-- #about Section end -->

    
 

@endsection

@section('footer')
    
@endsection

@section('scripts')
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    

  
   <script>
  function detectBrowser() {
            var useragent = navigator.userAgent;
            var mapdiv = document.getElementById("gmap");
            console.log(useragent.indexOf('iPhone'));
            if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1) {
               // mapdiv.style.width = '100%';
                //mapdiv.style.height = '100%';

                $("#gmap").css('margin-top',25);
                //mapdiv.style.margin-top = '25px';
            } else {
                //mapdiv.style.width = '600px';
                //mapdiv.style.height = '100%';
            }
        }
        detectBrowser();
        var directionDisplay;
var directionsService;
var infowindow;
var map;
var geocoder;

function initialize(position) {
	var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            
	directionsService = new google.maps.DirectionsService();
	infowindow = new google.maps.InfoWindow();
    directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });
        
    var mapOptions = {
    	center: new google.maps.LatLng(latitude, longitude), // puts your current location at the centre of the map,
        zoom: 15,
        mapTypeId: 'roadmap',
        gestureHandling: 'greedy',
        fullscreenControl: true
    }

    map = new google.maps.Map(document.getElementById("gmap"), mapOptions);

    directionsDisplay.setMap(map);
    calcRoute(position);
}

function calcRoute(position) {

			var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
    var start = new google.maps.LatLng(latitude, longitude);

    var end = new google.maps.LatLng({{$latitude}}, {{$longitude}});
    var newplace = 'VGN {{$list->Project_name}}';
    

    createMarker(start, 'Your Location');
    //geocodeAddress(geocoder, newplace);
    createMarker(end, 'VGN {{$list->Project_name}}');

    var request = {
        origin: start,
        destination: end,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
        }
    });
}

function createMarker(latlng, title) {

    var marker = new google.maps.Marker({
        position: latlng,
        title: title,
        map: map
    });

		infowindow.setContent(title);
        infowindow.open(map, marker);
    google.maps.event.addListener(marker, 'click', function () {
    	//console.log(title);
        infowindow.setContent(title);
        infowindow.open(map, marker);
    });
}
 function geoError() {
            alert("Enable the location service for the browser.");
        }
  function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(initialize, geoError);
                
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

      

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPMKwTWTLNHU1wofY_fPDzCdLmD9Ku6yY&callback=getLocation"
        async defer></script>
	
    <script>
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

  $("body").on('click', function(){
    $("#dropdown1").hide();
    $("#dropdown2").hide();
	  $("#dropdown3").hide();
  });
}
else
{
}
</script>
@endsection
