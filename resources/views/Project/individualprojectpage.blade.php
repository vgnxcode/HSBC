@extends('layout.app') @section('title') @if(View::exists('title.'.$list->id.'_website'.'_title')) @include('title.'.$list->id.'_website'.'_title') @else {{ $list->Project_name }} Landing Page @endif @endsection @section('description') @if(View::exists('metatags.'.$list->id.'_website'.'_metatags')) @include('metatags.'.$list->id.'_website'.'_metatags') @else
 <meta name="description" content="VGN {{ $list->Project_name }}, VGN Reputed Builders in Chennai, India. VGN offers luxury apartments, flats in Chennai with all amenities at low budget. To Know Our Latest Projects Contact VGN Builder. About VGN">
<meta name="keywords" content="{{ $list->Project_name }} Project vgn, {{ $list->Project_name }} project VGN Projects Estates Pvt Ltd,know more {{ $list->Project_name }} VGN Projects Estates Pvt Ltd, {{ $list->Project_name }} vgn flats " /> @endif @endsection @section('stylesheet')
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" /><link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.css" media="screen,projection" /><link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.transitions.css" media="screen,projection" /><link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.css" media="screen,projection" />
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" />
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/css/lightbox.min.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/blog.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/mobileflag/css/jquery.ccpicker.css">


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
    padding: 0px;
  }

  .enquireform ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    /* background-color: #eee; */
    font-size: 11px;
    color: #727272;
    text-transform: uppercase;
  }

  .breadcrumb li a {
    color: #000 !important;
  }

  .cc-picker {
    float: left;
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
    margin-top: 0;
  }

  /*.imgtitle {
    padding: 5px;
    background: #fff;
    border-radius: 5px;
    max-width: 212px;
}*/
  .map-container {
    padding-top: 0px;
    padding-bottom: 15px;
  }

  a.maplink {
    color: #F44336;
  }

  a.maplink:visited {
    color: #F44336;
  }

  .cc-picker {
    top: 35px;
  }

  .cc-picker-code-select-enabled {
    padding-right: 8px !important;
  }

  .flashit {
    -webkit-animation: flash linear 0.8s infinite;
    animation: flash linear 0.8s infinite;
  }

  @-webkit-keyframes flash {
    0% {
      opacity: 1;
    }

    50% {
      opacity: .1;
    }

    100% {
      opacity: 1;
    }
  }

  @keyframes flash {
    0% {
      opacity: 1;
    }

    50% {
      opacity: .1;
    }

    100% {
      opacity: 1;
    }
  }

  .owl-theme .owl-dots .owl-dot span {
    width: 5px;
    height: 5px;
    margin: 5px 2px;
    background: #D6D6D6;
    display: block;
    -webkit-backface-visibility: visible;
    transition: opacity .2s ease;
    border-radius: 15px;
  }

  .owl-theme .owl-dots .owl-dot.active span,
  .owl-theme .owl-dots .owl-dot:hover span {
    background: #ee6e73;
  }

  .btn-large,
  .btn-large p {
    background-color: #fff !important;
    color: #000 !important;
    box-shadow: none !important;
  }

  #nav-mobile li {
    border-bottom: 0 !important;
  }

  #nav-mobile li a {
    color: #fff !important;
  }

  #indivlist nav ul {
    /* margin-left:20px !important; */
    /* line-height:80px; */
  }

  #indivlist nav ul li {
    line-height: 50px;
    background-color: #000;
    font-weight: bold;
    text-align: center;
    min-width: 187px;
    width: auto;
    height: 50px;
    /* padding-left: 15px; */
    border: 1px solid #fff;
  }
  #floorplan a p i,#constructionprogress a p i,#ebrochure a p i,#youtube a p i{
    font-size:24px;
}
#floorplan,#constructionprogress,#ebrochure,#youtube{
    background-color:#000;
    padding:11px;
}
</style> @if($list->Type == 'Plots')
<!-- Facebook Pixel Code -->
<script>
  ! function(f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function() {
      n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
  }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '219397791799568'); // Insert your pixel ID here.
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=219397791799568&ev=PageView&noscript=1" />
</noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code --> @endif @endsection @section('header') @include('header.index') @endsection @section('content') <div class="preloader"></div> <?php
 $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name));
 $imgid = $list->id;
 
 ?>
<!-- @if(($list->id == '2') )
<section style="text-align: center;padding: 8px; text-transform: capitalize;font-weight: 600;"><div class="row"><div class="col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-5 flashit" style="background-color:#ff0000; border-radius: 5px;color: #FFFFFF;padding: 5px;border: 3.5px solid #ec8f0e;">
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
    @if(($list->id == '121'))
    <a href="https://ovalgardens-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Plot Online Now!</h2></a>
    @endif
    @if(($list->id == '116'))
    <a href="https://mayfieldpark-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Plot Online Now!</h2></a>
    @endif
    @if(($list->id == '123'))
    <a href="https://croftongarden-onlinebooking.vgn.in/register?locale=en" style="color: #FFFFFF;"  ><h2>Book Your Plot Online Now!</h2></a>
    @endif
  </div></div></section>
@endif -->
<section class="root-sec brand-bg" style="text-align:center;"> @if(Storage::disk('s3')->exists($banner)) <picture>
    <source media="(max-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$mobile_banner}}">
    <source media="(min-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$banner}}">
    <img src="{{ config('app.AWS_URL')}}/{{$banner}}" alt="
															<?php echo $projectname_str; ?>" title="
															<?php echo $projectname_str; ?>">
  </picture> @else <h2 class="title" style="color: #F44336; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 55px;">VGN {{ $list->Project_name }}</h2> @endif <div class="col-md-3 hide-on-med-and-down" style="position:absolute; top:4%; right:4%;">
    <div class="card s12">
      <div class="card-content">
        <span class="card-title" style="color: #EF533B;font-size: 18px;
    font-weight: 400;">For More Information Kindly Fill In</span>
        <form class="col s12" action="{{ url('/project/') }}/{{$projectname_str}}" method="post" style="color:#000;">
          {{ csrf_field() }}
          <div class="row">
            <div class="input-field col s8 m12">
              <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}"> {!! $errors->first('Name', ' <span class="errortext">:message</span>') !!} <label for="Name">Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s8 m10">
              <input id="Mobile1" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}" style="height: 3rem;padding-left: 70px;"> {!! $errors->first('Mobile', ' <span class="errortext">:message</span>') !!} <label for="Mobile">Mobile</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s8 m12">
              <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}"> {!! $errors->first('Email', ' <span class="errortext">:message</span>') !!} <label for="Email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s8 m12">
              <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}"> {!! $errors->first('City', ' <span class="errortext">:message</span>') !!} <label for="City">City</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s10 m12">
              <button type="submit" class="waves-effect waves-light btn red white-text">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section> @if($list->single_quote != null) <section class="root-sec " style="color:#000;padding: 10px;">
  <h2 class="newtitle center-align">{!! $list->single_quote !!}</h2>
</section> @endif @if($list->Status == 'Ongoing') <section class="root-sec enquireform ">
  <div class="row show-on-med-and-down hide-on-large-only">
    <div class="container" id="enquireformview">
      <div class="row">
        <form class="col s12" action="{{ url('/project/') }}/{{$projectname_str}}" method="post">
          {{ csrf_field() }}
          <div class="row p-0">
            <div class="input-field col-sm-12 ps-0">
              <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}"> {!! $errors->first('Name', ' <span class="errortext">:message</span>') !!} <label for="Name">Name</label>
            </div>
            <div class="input-field col-sm-12 ps-0">
              <input id="Mobile" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}" style=""> {!! $errors->first('Mobile', ' <span class="errortext">:message</span>') !!} <label for="Mobile">Mobile Number</label>
            </div>
            <div class="input-field col-sm-12 ps-0">
              <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}"> {!! $errors->first('Email', ' <span class="errortext">:message</span>') !!} <label for="Email">Email</label>
            </div>
            <div class="input-field col-sm-12 ps-0">
              <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}"> {!! $errors->first('City', ' <span class="errortext">:message</span>') !!} <label for="City">City</label>
            </div>
            <div class="input-field col-sm-12 ps-0">
            <button type="submit" class="btn btn-dark rounded-0 shadow-none" style="background-color:#000 !important">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <div class="row bread">
    <div class="clearfix about-inner">
      <ul class="breadcrumb">
        <li>
          <a href="{{ url('/') }}">Home</a>
        </li>
        <li>
          <a href="{{ url('/Premium-Real-Estate-Developers-in-Chennai') }}">Ongoing Projects</a>
        </li>
        <li>VGN {{$list->Project_name}}</li>
      </ul>
    </div>
  </div> -->
</section> @else 
<section class="root-sec enquireform ">
  <!-- <div class="row bread">
    <div class="clearfix about-inner">
      <ul class="breadcrumb">
        <li>
          <a href="{{ url('/') }}">Home</a>
        </li>
        <li>
          <a href="{{ url('/Flat-Builders-Chennai') }}">Completed Projects</a>
        </li>
        <li>VGN {{$list->Project_name}}</li>
      </ul>
    </div>
  </div> -->
</section> @endif <section id="indivlist" class="scroll-section root-sec white portfolio-wrap" style="padding-bottom:150px;">
  <nav id="tabnav" style="background-color:#fff !important; color:#000 !important; box-shadow:none !important;">
    <div class="nav-wrapper">
      <ul id="nav-mobile" class="left"> @if(($list->location_section != null) || ($list->googlemap_link != null)) <li>
          <a href="#location" data-section="#location" class="menu-smooth-scroll">Location</a>
        </li> @endif @if(View::exists('specification.'.$list->id)) <li>
          <a href="#specification" data-section="#specification" class="menu-smooth-scroll">Specfication</a>
        </li> @endif @if(View::exists('amenities.'.$list->id)) <li>
          <a href="#amenities" data-section="#amenities" class="menu-smooth-scroll">Amenities</a>
        </li> @endif @if(Storage::disk('s3')->exists('/images/siteplan/' . $list->id . '.jpg')) <li>
          <a href="#siteplan" data-section="#siteplan" class="menu-smooth-scroll">Site Plan</a>
        </li> @endif @if(Storage::disk('s3')->exists('/images/routemap/' . $list->id . '.jpg')) <li>
          <a href="#routemap" data-section="#routemap" class="menu-smooth-scroll">Route Map</a>
        </li> @endif @if(count($floorplanfiles) > 0) <li>
          <a href="#floorplan" data-section="#floorplan" class="menu-smooth-scroll">Floor Plan</a>
        </li> @endif @if(count($consplanfiles) > 0) <li>
          <a href="#constructionprogress" data-section="#constructionprogress" class="menu-smooth-scroll">Construction Progress</a>
        </li> @endif @if(count($ebrochplanfiles) > 0) <li>
          <a href="#ebrochure" data-section="#ebrochure" class="menu-smooth-scroll">E-Brochure</a>
        </li> @endif @if($list->youtube_link != null) <li>
          <a href="#youtube" data-section="#youtube" class="menu-smooth-scroll">Youtube</a>
        </li> @endif </ul>
    </div>
  </nav>
  <a href="#indivlist" class="pull-right btn-floating btn-large pulse red white-text button-middle call-to-home section-call-to-btn" style="position: fixed;" data-section="#indivlist">
    <i class="mdi-navigation-expand-less white-text"></i>
  </a>
</section>
<section id="portfolio" class="scroll-section root-sec white portfolio-wrap">
  <div class="container">
    <div class="row">
      <div class="col-sm-12"> @if(($list->location_section != null) || ($list->googlemap_link != null) || ($list->location_adv_section != null)) <div id="location">
          <div class="container single-post-content"> @if(($list->location_section != null)||($list->location_adv_section != null)) <div class="col-md-6 col-sm-12 single-post-page"> {!! $list->location_section !!} @if($list->location_adv_section != null) <h3>Location Advantages</h3> {!! $list->location_adv_section !!} @endif </div> @endif @if($list->googlemap_link != null) <div class="col-md-6 col-sm-12 ">
              <div class="map-container">
                <h3>View on Map</h3>
                <a id="loctionmap" class="btn white-text various iframe" href="{{$list->googlemap_link}}" style="margin-bottom: 3px;background-color: #000;font-weight: bold;">
                  <p style="color: #fff;">
                    <i class="mdi-maps-place"></i> Location Map
                  </p>
                </a>
              </div>
            </div> @endif </div>
        </div>
        <!-- <div class="divider"></div>  -->
        @endif @if(View::exists('specification.'.$list->id)) <div id="specification" class="padtop20">
          <div class="container single-post-content">
            <h3>Specifications</h3> @if(View::exists('specification.'.$list->id)) @include('specification.'.$list->id) @endif
          </div>
        </div>
        <!-- <div class="divider"></div>  -->
        @endif @if(View::exists('amenities.'.$list->id)) <div id="amenities" class="padtop20">
          <div class="container single-post-content">
            <!--<h2 class="styleheader">Amenities</h2>--> @if(View::exists('amenities.'.$list->id)) @include('amenities.'.$list->id) 
            @endif
          </div>
        </div>
        <!-- <div class="divider"></div>  -->
        @endif @if(Storage::disk('s3')->exists('/images/siteplan/' . $list->id . '.jpg')) <div id="siteplan" class="padtop20">
          <div class="container single-post-content">
            <div class="col-md-6 single-post-page">
              <h3>Site Plan</h3>
              <div class="card">
                <div class="card-image">
                  <img src="{{ config('app.AWS_URL')}}/images/siteplan/{{$list->id}}.jpg" alt="{{$list->Project_name}} Site Plan Image">
                </div>
                <div class="card-action center-align">
                  <a data-lightbox="image-1" data-title="Site Plan" href="{{ config('app.AWS_URL')}}/images/siteplan/{{$list->id}}.jpg">Click to View</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="divider"></div>  -->
        @endif @if(Storage::disk('s3')->exists('/images/routemap/' . $list->id . '.jpg')) <div id="routemap" class="padtop20">
          <div class="container single-post-content">
            <div class="col-md-6 single-post-page">
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
        <!-- <div class="divider"></div>  -->
        @endif 
        @if((count($floorplanfiles) > 0)||(count($consplanfiles) > 0)||(count($ebrochplanfiles) > 0)||$list->youtube_link != null))
        <!-- <div id="test" class="padtop20"> -->
        <!-- <div class="container-fluid single-post-content"> -->
        <div class="row"> @if(count($floorplanfiles) > 0) <div id="floorplan" class="col-md-3 col-sm-12 single-post-page">
            <!-- <h3>Floor Plan</h3> -->
            <a href="{{ url('/floorimages/') }}/{{$projectname_str}}" class="">
              <p style="color: #fff !important; text-align: left;">
                <i class="mdi-image-photo-library"></i>
                <span style="margin-left:5px;">Click to View  Floor Plans </span>
              </p>
            </a>
          </div> @endif @if(count($consplanfiles) > 0) <div id="constructionprogress" class="col-md-3 col-sm-12 single-post-page">
            <!-- <h3>Construction Progress</h3> -->
            <a href="{{ url('/constructionimages/') }}/{{$projectname_str}}" class="">
              <p style="color: #fff !important; text-align: left;">
                <i class="mdi-image-photo-library"></i> 
                <span style="margin-left:5px;">Click to View Construction Progress </span>
              </p>
            </a>
          </div> @endif @if(count($ebrochplanfiles) > 0) @foreach($ebrochplanfiles as $ebroch) <div id="ebrochure" class="col-md-3 col-sm-12 single-post-page">
            <!-- <h3>E-brochure</h3> -->
            <a href="{{ config('app.AWS_URL')}}/{{ $ebroch }}" class="" download>
              <p style="color: #fff !important; text-align: left;">
                <i class="mdi-file-file-download"></i> 
                <span style="margin-left:5px;">Download E-brochure </span>
              </p>
            </a>
          </div> @endforeach @endif @if($list->youtube_link != null) <div id="youtube" class="col-md-3 col-sm-12 single-post-page">
            <!-- <h3>Youtube</h3> -->
            <a href="//www.youtube.com/embed/{{$list->youtube_link}}?rel=0" class="">
              <p style="color: #fff !important; text-align: left;">
                <i class="mdi-av-video-collection"></i> 
                <span style="margin-left:5px;">Watch Project YouTube Video</span>
              </p>
            </a>
          </div> @endif </div>
        <!-- </div></div> -->
        <!-- <div class="divider"></div> --> 
        @endif
      </div>
    </div>
  </div>
  <!-- <div class="fab-container hide-on-small-only">
    <div class="top fab btn-floating btn-large red">
      <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
    </div>
  </div> -->
</section> @endsection @section('footer') @include('footer.index') @if($list->Type == 'Plots')
<!-- Google Code for Remarketing Tag -->
<script type="text/javascript">
  /* 
																								<![CDATA[ */
  var google_conversion_id = 864630853;
  var google_custom_params = window.google_tag_params;
  var google_remarketing_only = true;
  /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
  <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/864630853/?guid=ON&amp;script=0" />
  </div>
</noscript> @endif @endsection @section('scripts') 
<!-- <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/js/lightbox.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
<script src="{{ config('app.AWS_URL')}}/mobileflag/js/jquery.ccpicker.js" type="text/javascript"></script> -->


<script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> -->
<script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!-- <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script> -->
<script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min_new.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->
<script src="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/js/lightbox.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
<script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
<script src="{{ config('app.AWS_URL')}}/mobileflag/js/jquery.ccpicker.js" type="text/javascript"></script>
<script>
  $(window).load(function() {
    $('.preloader').fadeOut('slow');
  });
  $(document).ready(function() {
    $("#loctionmap").fancybox();
    $("#Mobile").CcPicker();
    $("#Mobile").CcPicker("setCountryByCode", "IN");
    $("#Mobile1").CcPicker();
    $("#Mobile1").CcPicker("setCountryByCode", "IN");
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      //console.log(navigator.userAgent);
      $(".layerimage").css('height', 450);
      // $('#tabnav').hide();
    }
    $('#Name, #City').on('change', function() {
      $(this).val($(this).val().toUpperCase());
    });
  });
</script> @if(session()->has('24hours')) <script>
  swal({
    title: "Warning",
    text: "You can enquire after {{ Carbon\Carbon::parse(Session::get('24hours'))->format('d,M Y h:i:s A') }}",
    type: "warning"
  });
</script> @endif <script>
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    $("body").on('click', function() {
      $("#dropdown1").hide();
      $("#dropdown2").hide();
      $("#dropdown3").hide();
    });
  } else {}
</script> @endsection