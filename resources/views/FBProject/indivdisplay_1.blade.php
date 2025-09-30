@extends('layout.app')

@section('title')

@if(View::exists('title.'.$list->id.'_gf'.'_title'))
        @include('title.'.$list->id.'_gf'.'_title')
    @else
{{ $list->Project_name }} Facebook Landing Page
  @endif

@endsection

@section('description')
       @if(View::exists('metatags.'.$list->id.'_gf'.'_metatags'))
        @include('metatags.'.$list->id.'_gf'.'_metatags')
    @else
       <meta name="description" content="VGN Reputed Builders in Chennai, India. VGN offers luxury apartments, flats in Chennai with all amenities at low budget. To Know Our Latest Projects Contact VGN Builder. About VGN">
       <meta name="keywords" content="{{ $list->Project_name }} Project vgn, {{ $list->Project_name }} project vgn property developers,know more {{ $list->Project_name }} vgn property developers, {{ $list->Project_name }} vgn homes "/>
    @endif
@endsection



@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/materialize/css/materialize.min.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" media="screen,projection" />

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert/sweet-alert.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.carousel.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.transitions.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.theme.css') }}" media="screen,projection" />

    <link rel="stylesheet" href="{{ asset('assets/libs/lightbox2/dist/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
  
    <link rel="stylesheet" href="{{ asset('assets/css/colors/color1.css') }}">
    @if(View::exists('pixelcodes.facebook.'.$list->id.'_landingpage'))
      @include('pixelcodes.facebook.'.$list->id.'_landingpage')
    @endif
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
    padding-bottom: 0px;
}

span .errortext {
    color:#FF0000;
}
.card .card-content .card-title{
  line-height: 28px;
}
a.maplink{
  color: #F44336;
}
a.maplink:visited{
  color: #F44336;
}
</style>
 <!--Start of vgn developers Zendesk Chat Script-->
<script type="text/javascript">

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  //mobile
}
else
{
  
  //document.getElementById( 'plogo' ).style.paddingTop = '10px'
  window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?4e7uzpagzHqjP2GEIbhq4inw2TUIrfnT";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
}

</script>
<!--End of vgn developers  Zendesk Chat Script-->
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')

<?php $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name));

if($list->Type == 'Apartments'){
    $singlrname = 'Apartment';
}
if($list->Type == 'Plots'){
    $singlrname = 'Plot';
}

?>

@if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))
    <section id="banner" class="root-sec brand-bg  single-banner blogpage-banner-wrap" style="margin-bottom: 0px;">

    <div class="layerimage" style="background: url({{ asset('/images/banner/')}}/{{$list->id}}.jpg) no-repeat scroll center center / cover;height: 400px;">
    <div class="secinner padd-tb-50" style="height: 100%; width: 100%;">
 @else
  <section id="banner" class="root-sec brand-bg padd-tb-55 single-banner blogpage-banner-wrap" style="margin-bottom: 0px;">
@endif

<div class="container" style="padding: 24px;">
        <div class="row">

          <div class="col-md-8">

          @if(file_exists( public_path() . '/images/project_logo/' . $list->id . '.jpg'))
          @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <img src="{{ url('/images/project_logo/') }}/{{$list->id}}.jpg" class="img-responsive title imgtitle" style="padding-top: 55px;" id="plogo" alt="Project Logo">
          @endif
          
          @else
          @if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))
          @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <h2 class="title" style="color: #F44336; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 55px;">VGN {{ $list->Project_name }}</h2>
          @endif
          @else
          @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <h2 class="title" style="color: #fff; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 55px;">VGN {{ $list->Project_name }}</h2>
          @endif
          @endif
          @endif
          </div>
          <div class="col-md-4 hide-on-small-only" style="top: 0;right: -45px;">
            <div class="card s12">
               <div class="card-content" style="text-align: center;" >
                      <span class="card-title" style="color: #EF533B;font-size: 18px;
    font-weight: 400;">For more information Kindly Fill in</span>
            <form class="col s12" action="{{ url('/facebook-display/project/') }}/{{$projectname_str}}" method="post" style="color:#000;">
                      {{ csrf_field() }}
                       @if(session()->has('error_msg'))
						<span style="color:red;">{!! Session::get('error_msg') !!}</span>
					@endif
					@if(session()->has('suc_msg'))
						<span style="color:green;">{!! Session::get('suc_msg') !!}</span>
				@endif
                    <div class="row">
                      <div class="input-field col s10 m12">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Name</label>
                    </div>                     
                    </div>

                    <div class="row">   
                     <div class="input-field col s10 m12">
                        <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>
                    </div>

                  

                    <div class="row">
                    <div class="input-field col s10 m6">
                       <input id="Mobile" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile Number</label>
                    </div>
                    <div class="input-field col s10 m6">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                    </div>

                
                    <div class="row">
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text" >Verify OTP & Submit</button>
                    </div>
                    </div>
                    
                    </form>

            </div>
            </div>
          </div>

</div>
</div>


@if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))
    </div>
    </div>

    </section>
    @else
    </div>

    </section>
@endif
    



@if($list->single_quote != null)
    <section class="root-sec " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">{{ $list->single_quote }}</h2>
</section>
@endif

@if($list->Status == 'Ongoing')
<section class="root-sec enquireform " id="mobform">
    <div class="row hide-on-med-and-up hide-on-large-only">
        <div class="container" id="enquireformview">
            <div class="card s12">
               <div class="card-content" style="text-align: center;" >
                            <span class="card-title" style="color: #EF533B;font-size: 18px;
    font-weight: 400;">For more information Kindly Fill in</span>
                 <div class="row">
                   
                    <form class="col s12" action="{{ url('/facebook-display/project/') }}/{{$projectname_str}}" method="post">
                      {{ csrf_field() }}
                       @if(session()->has('error_msg'))
						<div style="color:#FF0000;">{!! Session::get('error_msg') !!}</div>
					@endif
					@if(session()->has('suc_msg'))
						<span style="color:green;">{!! Session::get('suc_msg') !!}</span>
				@endif
                    <div class="row">
                      <div class="input-field col s10 m3">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Name</label>
                    </div>

                     <div class="input-field col s10 m3">
                        <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>

                    <div class="input-field col s10 m2">
                       <input id="Mobile" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile Number</label>
                    </div>
                    
                    
                     <div class="input-field col s10 m2">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                   
                    <div class="input-field col s12 m10">
                    <button type="submit" class="waves-effect waves-light btn red white-text" >Verify OTP & Submit</button>
                    </div>
                    
                    </div>
                    </form>
                    </div>
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


<section id="portfolio" class="scroll-section root-sec white portfolio-wrap" style="padding-bottom: 0px;">


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
      @if($latitude != 0)
      <div style="margin-bottom: 10px;text-align: center;">
          <a href="{{url('/googlemap')}}/{{$projectname_str}}" class="maplink" style="font-size: 18px;" target="_blank"><i class="fa fa-map-marker fa-2x"></i> Click Here to get Live Direction</a>
        </div>
      @endif
        <div class="map-container">
        <iframe src="{{$list->googlemap_link}}"></iframe>
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
    <div class="divider"></div>
@endif

@if(file_exists( public_path() . '/images/siteplan/' . $list->id . '.jpg'))
<div id="siteplan" class="padtop20">
    <div class="container single-post-content">
        <div class="col-md-6 single-post-page">
            <!--<h2 class="styleheader">Site Plan</h2>-->
			<h3>Site Plan</h3>

            <div class="card">
            <div class="card-image">
              <img src="/images/siteplan/{{$list->id}}.jpg">
              
            </div>
            
            <div class="card-action center-align">
              <a data-lightbox="image-1" data-title="Site Plan" href="/images/siteplan/{{$list->id}}.jpg">Click to View</a>
            </div>
          </div>

        </div>

        </div>

</div>

<div class="divider"></div>
@endif

@if(file_exists( public_path() . '/images/routemap/' . $list->id . '.jpg'))
<div id="routemap" class="padtop20">
    <div class="container single-post-content">
        <div class="col-md-6 single-post-page">
            <!--<h2 class="styleheader">Route Map</h2>-->
			<h3>Route Map</h3>

            <div class="card">
            <div class="card-image">
              <img src="/images/routemap/{{$list->id}}.jpg">
              
            </div>
            
            <div class="card-action center-align">
              <a data-lightbox="image-2" data-title="Route Map" href="/images/routemap/{{$list->id}}.jpg"><p>Click to View</p></a>
            </div>
          </div>

        </div>

        </div>

</div>

<div class="divider"></div>
@endif


@if((count($floorplanfiles) > 0)||(count($consplanfiles) > 0)||(count($ebrochplanfiles) > 0))
<div id="test" class="padtop20">
    <div class="container single-post-content">

        @if(count($floorplanfiles) > 0)
        <div id="floorplan" class="col-md-4 col-sm-12 single-post-page">
            <h3>Floor Plan</h3>

            
            <a href="{{ url('/floorimages/') }}/{{$projectname_str}}" class="waves-effect waves-light btn btn-large white-text "><p style="color: #fff;"><i class="mdi-image-photo-library"></i> <span >Click to View</span></p></a>

        </div>
        @endif

        @if(count($consplanfiles) > 0)
        <div id="constructionprogress" class="col-md-4 col-sm-12 single-post-page">
            <h3>Construction Progress</h3>

            <a href="{{ url('/constructionimages/') }}/{{$projectname_str}}" class="waves-effect waves-light btn btn-large white-text "><p style="color: #fff;"><i class="mdi-image-photo-library"></i> Click to View</p></a>

        </div>
        @endif
        @if(count($ebrochplanfiles) > 0)
        @foreach($ebrochplanfiles as $ebroch)
        <div id="ebrochure" class="col-md-4 col-sm-12 single-post-page">
            <h3>E-brochure</h3>

            <a href="{{ url('/images/ebrochure/') }}/{{$list->id}}/{{ $ebroch->getRelativePathName() }}" class="waves-effect waves-light btn btn-large white-text" download><p style="color: #fff;"><i class="mdi-file-file-download"></i> Download Now</p></a>

        </div>
        @endforeach
        @endif

        </div>

</div>
<div class="divider"></div>
@endif


@if($list->youtube_link != null)


<div id="youtube" class="padtop20">
    <div class="container single-post-content">
        <div id="floorplan" class="col-md-10 single-post-page">
            <!--<h2 class="styleheader">Youtube</h2>-->
			<h3>Youtube</h3>

              <div class="video-container" style="padding-bottom: 10%;">
        <iframe width="853" height="480" src="//www.youtube.com/embed/{{$list->youtube_link}}?rel=0" frameborder="0" allowfullscreen></iframe>
      </div>


            </div>
</div>
</div>
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
    <script src="{{ asset('assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/detectmobilebrowser.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    
    <script src="{{ asset('assets/libs/sweetalert/sweet-alert.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>

  
    <script src="{{ asset('assets/libs/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/materialize/js/materialize.min.js') }}"></script>

    <script src="{{ asset('assets/libs/lightbox2/dist/js/lightbox.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
     

 <script>
      $( document ).ready(function() {
         if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) { 
            $(".layerimage").css('height',450);
          }
     
          $('#Name, #City').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});
  if(jQuery.browser.mobile)
{
  //var bgimage = $( ".layerimage" ).css( "background-image" );
  @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
  
    $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/mobile/<?php echo $list->id; ?>.jpg)");
    @else
      $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/<?php echo $list->id; ?>.jpg)");
    @endif
   console.log('You are using a mobile device!');
}

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