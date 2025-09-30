@extends('layout.app')

@section('title')

@if(View::exists('title.'.$list->id.'_gf'.'_title'))
        @include('title.'.$list->id.'_gf'.'_title')
    @else
{{ $list->Project_name }} Linkedin OTP Landing Page
  @endif

@endsection

@section('description')
       @if(View::exists('metatags.'.$list->id.'_gf'.'_metatags'))
        @include('metatags.'.$list->id.'_gf'.'_metatags')
    @else
       <meta name="description" content="VGN Reputed Builders in Chennai, India. VGN offers luxury apartments, flats in Chennai with all amenities at low budget. To Know Our Latest Projects Contact VGN Builder. About VGN">
       <meta name="keywords" content="{{ $list->Project_name }} Project vgn, {{ $list->Project_name }} project VGN Projects Estates Pvt Ltd,know more {{ $list->Project_name }} VGN Projects Estates Pvt Ltd, {{ $list->Project_name }} vgn homes "/>
    @endif
@endsection



@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.css">

    <!--<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.transitions.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.css" media="screen,projection" />-->
   
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css"  />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/blog.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    
    <style>
    h2.styleheader {
      font-size: 32px;
    line-height: 1.1;
    font-weight: 300;
    text-transform: uppercase;
    margin-bottom: 35px;
    font-family: 'Roboto', sans-serif;
    color: #F44336;
    }
     .enquireform {
      padding:0px;
    }
    
     .enquireform ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    background-color: #eee;
    font-size: 11px;
    color: #727272;
    text-transform: uppercase;
    
}

/* Display list items side by side */
.enquireform ul.breadcrumb li {
    display: inline;
}

/* Add a slash symbol (/) before/behind each list item */
.enquireform ul.breadcrumb li+li:before {
    padding: 8px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
.enquireform ul.breadcrumb li a {
    text-decoration: none;
}

/* Add a color on mouse-over */
.enquireform ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}

.bread .about-inner {
  margin: 0px 0px 0px 10px
}
.single-post-content h3 {
  
    color: #F44336;
}

.input-field {
    margin-top:0;
}

/*.imgtitle {
    padding: 5px;
    background: #fff;
    border-radius: 5px;
    max-width: 212px;
}*/

.map-container
{
    padding-top: 0px;
    padding-bottom: 15px;
}
.card .card-content .card-title{
  line-height: 28px;
}

span .errortext {
    color:#FF0000;
}
a.maplink{
  color: #F44336;
}
a.maplink:visited{
  color: #F44336;
}
.flashit {
    -webkit-animation: flash linear 0.8s infinite;
    animation: flash linear 0.8s infinite;
}

@-webkit-keyframes flash {
  0% { opacity: 1; } 
  50% { opacity: .1; } 
  100% { opacity: 1; }
}
@keyframes flash {
  0% { opacity: 1; } 
  50% { opacity: .1; } 
  100% { opacity: 1; }
}
</style>
 
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')

<script type="text/javascript">
_linkedin_partner_id = "376267";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(){var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=376267&fmt=gif" />
</noscript>
<?php 
$projectname_str = strtolower(str_replace(' ', '_', $list->Project_name));
$imgid = $list->id;
 ?>

<!-- @if($list->id == '2')
<section style="text-align: center;padding: 8px; text-transform: capitalize;font-weight: 600;">
  <div class="row">
  <div class="col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-5 flashit" style="background-color:#ff0000; border-radius: 5px;color: #FFFFFF;padding: 5px;border: 3.5px solid #ec8f0e;">
    @if(($list->id == '1'))
    <a href="https://nottinghill-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Flat Online Now!</h2></a>
    @endif
    @if(($list->id == '2'))
    <a href="https://fairmont-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Flat Online Now!</h2></a>
    @endif
    @if(($list->id == '5'))
    <a href="https://coasta-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Flat Online Now!</h2></a>
    @endif
    @if(($list->id == '13'))
    <a href="https://stafford-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Flat Online Now!</h2></a>
    @endif
    @if(($list->id == '14'))
    <a href="https://templetown-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Flat Online Now!</h2></a>
    @endif
  </div>
  </div>
</section>
@endif -->
<section style="position:relative;text-align:center;">
    
      <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$mobile_banner}}">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$banner}}">

          <img src="{{ config('app.AWS_URL')}}/{{$banner}}" alt="<?php echo $projectname_str; ?>" title="<?php echo $projectname_str; ?>">
        </picture>
    @if(session()->has('otpdata'))
    <div class="col-md-3 hide-on-med-and-down" style="position:absolute; top:10%; right:5%;">
                <div class="card s12">
                   <div class="card-content" style="text-align: center;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;">For more information Kindly Fill in</span>


<form class="col s12" action="{{ $currentroute }}" method="post" style="color:#000;">
                      {{ csrf_field() }}
                    
                  @if(session()->has('error_msg'))
						<span style="color:red;">{!! Session::get('error_msg') !!}</span>
					@endif
					@if(session()->has('suc_msg'))
						<span style="color:green;">{!! Session::get('suc_msg') !!}</span>
				@endif
																				

                    <div class="row">
                  <div class="input-field col s10 m12">
                        <input id="otp" type="number" name="otp" class="validate" pattern="\d*" value="{{ old('otp')}}">
                        {!! $errors->first('otp', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Enter OTP Code</label>
                    </div>
                    </div>

                    <div class="row">
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text">Verify</button>
                    <button type="button" onclick="window.location.href='{{ $getotplogouturl }}'" class="waves-effect waves-light btn red white-text">Cancel</button>
                    </div>
                    </div>
                    
                    </form>


        </div>
                </div>
              </div>
    @endif
    
    </section>  



@if($list->single_quote != null)
    <section class="root-sec hide-on-med-and-down " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">{!! $list->single_quote !!}</h2>
</section>
@endif

@if($list->Status == 'Ongoing')

<section class="root-sec show-on-med-and-down " style="background-color: #EF533B; padding: 5px;">
<div class="row">
    <div class="center-align">

          @if(file_exists( public_path() . '/images/project_logo/' . $list->id . '.jpg'))
          
          @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <img src="{{ url('/images/project_logo/') }}/{{$list->id}}.jpg" class="img-responsive title imgtitle" style="padding-top: 15px;" alt="Project Logo">
          @endif
          
          @else
          @if(Storage::disk('s3')->exists('/images/banner/' . $list->id . '.jpg'))
           @if(Storage::disk('s3')->exists('/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <h2 class="title" style="color: #F44336; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 15px;">VGN {{ $list->Project_name }}</h2>
          @endif
          @else
          @if(Storage::disk('s3')->exists('/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <h2 class="title" style="color: #fff; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 15px;">VGN {{ $list->Project_name }}</h2>
          @endif
          @endif
          @endif
          </div>
</div>
</section>
<section class="root-sec enquireform " id="mobform">
    <div class="row show-on-med-and-down hide-on-large-only">
        <div class="container" id="enquireformview">
            <div class="card s12">
               <div class="card-content" style="text-align: center;">
                            <span class="card-title" style="color: #EF533B;font-size: 18px;
    font-weight: 400;">For more information Kindly Fill in</span>
            @if(session()->has('otpdata'))
                 <div class="row">
                   
                    <form class="col s12" action="{{ $currentroute }}" method="post">
                      {{ csrf_field() }}
                       @if(session()->has('error_msg'))
						<div style="color:#FF0000;">{!! Session::get('error_msg') !!}</div>
					@endif
					@if(session()->has('suc_msg'))
						<span style="color:green;">{!! Session::get('suc_msg') !!}</span>
				@endif
                    <div class="row">
                      <div class="input-field col s10 m12">
                        <input id="otp" type="number" name="otp" class="validate" pattern="\d*" value="{{ old('otp')}}">
                        {!! $errors->first('otp', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Enter OTP Code</label>
                    </div>
                    </div>

                    <div class="row">
                    <div class="input-field col s12 m10">
                    <button type="submit" class="waves-effect waves-light btn red white-text col s4 m6" >Verify</button>
                    <button type="button" onclick="window.location.href='{{ $getotplogouturl }}'" class="waves-effect waves-light btn red white-text col s4 m6">Cancel</button>
                    </div>
                    </div>
                    
                    </div>
                    </form>
                    </div>
                    @endif
                    </div>
                    </div>
            
        </div>
    </div>

   <!--  <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Real-Estate-Developers-in-Chennai') }}">Ongoing Projects</a></li>
  <li>VGN {{$list->Project_name}}</li>
</ul>
</div>
        </div> -->
</section>

 <section class="root-sec hide-on-med-and-up " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">{!! $list->single_quote !!}</h2>
</section>

@else
<!-- <section class="root-sec enquireform ">
 <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Chennai-Flat-Builders') }}">Completed Projects</a></li>
  <li>VGN {{$list->Project_name}}</li>
</ul>
</div>
        </div>
</section> -->
@endif




<!-- <section  id="indivlist" class="scroll-section root-sec white portfolio-wrap" style="padding-bottom:30px;">

<nav>
    <div class="nav-wrapper">
      <ul id="nav-mobile" class="left">
      @if(($list->location_section != null) || ($list->googlemap_link != null))
        <li><a href="#location" data-section="#location" class="menu-smooth-scroll" >Location</a></li>
      @endif
      
      @if(View::exists('amenities.'.$list->id))
        <li><a href="#amenities" data-section="#amenities" class="menu-smooth-scroll">Amenities</a></li>
      @endif
      </ul>
    </div>
  </nav>
        
  
</section> -->


<section id="portfolio" class="scroll-section root-sec white portfolio-wrap">


<div class="container">
          <div class="row">
            <div class="col-sm-12">

@if(($list->location_section != null) || ($list->googlemap_link != null) || ($list->location_adv_section != null))
              <div id="location" class="padtop20" >      
      <div class="container single-post-content" style="margin-bottom: 0px;">
  @if(($list->location_section != null)||($list->location_adv_section != null))
    <div class="col-md-6 col-sm-12 single-post-page">
      
      
                  {!! $list->location_section !!}
                  @if($list->location_adv_section != null)
        <h3>Location Advantages</h3>
        {!! $list->location_adv_section !!}
                  @endif
      </div>
@endif
      @if($list->googlemap_link != null)
      <div class="col-md-6 col-sm-12">
         <div class="map-container">
        
            <h3>View on Map</h3>

       <a id="loctionmap" class="waves-effect waves-light btn btn-large white-text various iframe" href="{{$list->googlemap_link}}" style="margin-bottom: 3px;"><p style="color: #fff;"><i class="mdi-maps-place"></i> Location Map</p></a>
      </div>  

        
      </div>
      @endif

</div>
    </div>

      <div class="divider"></div>
@endif

@if(View::exists('specification.'.$list->id))
<div id="specification" class="padtop20">
      
    
      <div class="container single-post-content">
  <h3>Specifications</h3>
  @if(View::exists('specification.'.$list->id))
    @include('specification.'.$list->id)
@endif
		  
</div>
</div>

@endif

@if(View::exists('amenities.'.$list->id))
<div id="amenities" class="padtop20">
      
      
      <div class="container single-post-content">
      
  @if(View::exists('amenities.'.$list->id))
   @include('amenities.'.$list->id)
  @endif
    
		 

    </div>
    

    </div>

@endif

@if(Storage::disk('s3')->exists('/images/siteplan/' . $list->id . '.jpg'))
<div id="siteplan" class="padtop20">
    <div class="container single-post-content">
        <div class="col-md-6 single-post-page">
            <!--<h2 class="styleheader">Site Plan</h2>-->
			<h3>Site Plan</h3>

            <div class="card">
            <div class="card-image">
              <img src="{{ config('app.AWS_URL')}}/images/siteplan/{{$list->id}}.jpg">
              
            </div>
            
            <div class="card-action center-align">
              <a data-lightbox="image-1" data-title="Site Plan" href="{{ config('app.AWS_URL')}}/images/siteplan/{{$list->id}}.jpg">Click to View</a>
            </div>
          </div>

        </div>

        </div>

</div>

<div class="divider"></div>
@endif

@if(Storage::disk('s3')->exists('/images/routemap/' . $list->id . '.jpg'))
<div id="routemap" class="padtop20">
    <div class="container single-post-content">
        <div class="col-md-6 single-post-page">
            <!--<h2 class="styleheader">Route Map</h2>-->
			<h3>Route Map</h3>

            <div class="card">
            <div class="card-image">
              <img src="{{ config('app.AWS_URL')}}/images/routemap/{{$list->id}}.jpg">
              
            </div>
            
            <div class="card-action center-align">
              <a data-lightbox="image-2" data-title="Route Map" href="{{ config('app.AWS_URL')}}/images/routemap/{{$list->id}}.jpg">Click to View</a>
            </div>
          </div>

        </div>

        </div>

</div>

<div class="divider"></div>
@endif

@if((count($floorplanfiles) > 0)||(count($consplanfiles) > 0)||(count($ebrochplanfiles) > 0)||($list->youtube_link != ''))
<div id="test" class="padtop20">
    <div class="container single-post-content">

        @if(count($floorplanfiles) > 0)
        <div id="floorplan" class="col-md-3 col-sm-12 single-post-page">
            <h3>Floor Plan</h3>

            
            <a href="{{ url('/floorimages/') }}/{{$projectname_str}}" class="waves-effect waves-light btn btn-large white-text "><p style="color: #fff;"><i class="mdi-image-photo-library"></i> <span >Click to View</span></p></a>

        </div>
        @endif

        @if(count($consplanfiles) > 0)
        <div id="constructionprogress" class="col-md-3 col-sm-12 single-post-page">
            <h3>Construction Progress</h3>

            <a href="{{ url('/constructionimages/') }}/{{$projectname_str}}" class="waves-effect waves-light btn btn-large white-text "><p style="color: #fff;"><i class="mdi-image-photo-library"></i> Click to View</p></a>

        </div>
        @endif
        @if(count($ebrochplanfiles) > 0)
        @foreach($ebrochplanfiles as $ebroch)
        <div id="ebrochure" class="col-md-3 col-sm-12 single-post-page">
            <h3>E-brochure</h3>

            <a href="{{ config('app.AWS_URL')}}/{{ $ebroch }}" class="waves-effect waves-light btn btn-large white-text" download><p style="color: #fff;"><i class="mdi-file-file-download"></i> Download Now</p></a>

        </div>
        @endforeach
        @endif

         @if($list->youtube_link != '')
        
        <div id="youtube" class="col-md-3 col-sm-12 single-post-page">
            <h3>Youtube</h3>

            <a href="//www.youtube.com/embed/{{$list->youtube_link}}?rel=0" class="waves-effect waves-light btn btn-large white-text"><p style="color: #fff;"><i class="mdi-av-video-collection"></i> Watch Now</p></a>

        </div>
        
        @endif

        </div>

</div>
<div class="divider"></div>
@endif

    
   
    
  



</div>
</div>





</div>

 

</section>


<section  class="root-sec " style="background-color: #EF533B;margin-bottom:80px; padding:20px;">
<div class="container">
<div class="row">
    
    <div class="center-align">
        <h2 class="newtitle center-align">For Other Project Details</h2><br>
        <!-- <a href="#banner" data-section="#banner" class="menu-smooth-scroll waves-effect waves-light btn white red-text">Enquire now</a> -->
        <a href="{{url('/Premium-Real-Estate-Developers-in-Chennai')}}" class="waves-effect waves-light btn white red-text">Search now</a>
    </div>
    </div>
    </div>

<div class="fab-container">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
</section>


@endsection

@section('footer')
    @include('landing_footer.index')
@endsection

@section('scripts')
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <!--<script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js') }}"></script>-->
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>

    <script src="{{ config('app.AWS_URL')}}/assets/libs/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>

    <script src="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/js/lightbox.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
     @if(View::exists('pixelcodes.google.'.$list->id.'_landingpage'))
      @include('pixelcodes.google.'.$list->id.'_landingpage')
    @endif
    <script>
    
      $( document ).ready(function() {
        $("#loctionmap").fancybox();
         if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) { 
            
            $('#tabnav').hide();
          }
    
          $('#Name, #City').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});
       




});
    </script>
     @if(session()->has('24hours'))
    <script>
    swal({
  title: "Warning",
  text: "You can enquire after {{ Carbon\Carbon::parse(Session::get('24hours'))->format('d,M Y h:i:s A') }}",
  type: "warning"
});
</script>
    @endif

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
