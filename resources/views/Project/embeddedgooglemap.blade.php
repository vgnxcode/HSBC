@extends('layout.app')

@section('title')
VGN:{{ $list->Project_name }} google map location
@endsection

@section('description')
    <META NAME="Subject" CONTENT="{{ $list->Project_name }} google map">
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
@if($gmapvalid == 0)
<script> 
    alert('No Data Available');
window.location.href ='{{ url()->full() }}';</script>
@endif
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist" style="margin-top: 40px;">
      

        
       
               

			<div class="row">
            <!-- <div id="gmap" style="height:600px;" ></div> -->

            <iframe id="frame" src="{{$embedlink}}"></iframe>
  			
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

      function initMap() {
        var locationRio = {lat: -22.915, lng: -43.197};
        var map = new google.maps.Map(document.getElementById('frame'), {
          zoom: 13,
          center: locationRio,
          gestureHandling: 'greedy'
        });
        var marker = new google.maps.Marker({
          position: locationRio,
          map: map,
          title: 'Hello World!'
        });
      }
    
    

        $(window).load(function() {

    var wheight = $(window).height();
    var newheight = wheight - 97;

    $("#frame").css('cssText', 'height: '+newheight+'px; width: 100%;');

});
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
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPMKwTWTLNHU1wofY_fPDzCdLmD9Ku6yY&callback=initMap">
    </script>
@endsection