@extends('layout.app')

@section('title')

@if(View::exists('title.'.$list->id.'_gf'.'_title'))
        @include('title.'.$list->id.'_gf'.'_title')
    @else
{{ $list->Project_name }} Landing Page
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
    </style>
 <!--Start of vgn developers Zendesk Chat Script-->
<script type="text/javascript">

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  //mobile
}
else
{
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

<?php $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name)); ?>

<section style="position:relative;text-align:center;">
    
    <img src="#" id="bannerim" style="width:100%;"  alt="Project Image">
    
    <div class="col-md-4 hide-on-med-and-down" style="position:absolute; top:10%; right:5%;">
                <div class="card s12">
                   <div class="card-content" style="text-align: center;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;">For more information Kindly Fill in</span>
            <form class="col s12" action="{{ url('/googlead/project/') }}/{{$projectname_str}}" method="post" style="color:#000;">
                      {{ csrf_field() }}
                    <div class="row">
                      <div class="input-field col s10 m12">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Name</label>
                    </div>                     
                    </div>

                    <div class="row">   
                     <div class="input-field col s10 m12">
                        <input id="Email" type="text" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>
                    </div>

                  

                    <div class="row">
                    <div class="input-field col s10 m6">
                       <input id="Mobile" type="text" name="Mobile" class="validate" value="{{ old('Mobile')}}">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile Number</label>
                    </div>
                    <div class="input-field col s10 m6">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                    </div>
                    
                  
                    <!--<div class="row">
                    <div class="input-field col s10 m12">
                         <input id="Message" type="text" name="Message" class="validate" value="{{ old('Message')}}">
                         {!! $errors->first('Message', '<span class="errortext">:message</span>') !!}
                        <label for="Message">Message</label>
                    </div>
                    </div>-->
                    <div class="row">
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text" >Submit</button>
                    </div>
                    </div>
                    
                    </form>

            </div>
                </div>
              </div>
    
    
    </section>  



@if($list->single_quote != null)
    <section class="root-sec " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">{{ $list->single_quote }}</h2>
</section>
@endif

@if($list->Status == 'Ongoing')
<section class="root-sec enquireform " id="mobform">
    <div class="row show-on-med-and-down">
        <div class="container">
            
                 <div class="row">
                   
                    <form class="col s12" action="{{ url('/googlead/project/') }}/{{$projectname_str}}" method="post">
                      {{ csrf_field() }}
                    <div class="row">
                      <div class="input-field col s10 m10">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Name</label>
                    </div>

                     <div class="input-field col s10 m10">
                        <input id="Email" type="text" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>

                    <div class="input-field col s10 m10">
                       <input id="Mobile" type="text" name="Mobile" class="validate" value="{{ old('Mobile')}}">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile Number</label>
                    </div>
                    
                    
                     <div class="input-field col s10 m10">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                   <!-- <div class="input-field col s10 m10">
                         <input id="Message" type="text" name="Message" class="validate" value="{{ old('Message')}}">
                         {!! $errors->first('Message', '<span class="errortext">:message</span>') !!}
                        <label for="Message">Message</label>
                    </div>-->
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text" >Submit</button>
                    </div>
                    
                    </div>
                    </form>
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
        <h3>Advantage:</h3>
        {!! $list->location_adv_section !!}
                  @endif
      </div>
@endif
      @if($list->googlemap_link != null)
      <div class="col-md-6 col-sm-12 map-container">
      
        <iframe src="{{$list->googlemap_link}}"></iframe>
      </div>
      @endif

</div>
    </div>

      <div class="divider"></div>
@endif



@if(View::exists('amenities.'.$list->id))
<div id="amenities" class="padtop20">
      
      
      <div class="container single-post-content">
      <h2 class="styleheader">Amenities</h2>
  @if(View::exists('amenities.'.$list->id))
   @include('amenities.'.$list->id)
  @endif
    

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
        <h2 class="newtitle center-align">For More Project Details</h2><br>
       <!--  <a href="#banner" data-section="#banner" class="menu-smooth-scroll waves-effect waves-light btn white red-text">Enquire now</a> -->
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
     @if(View::exists('pixelcodes.google.'.$list->id.'_landingpage'))
      @include('pixelcodes.google.'.$list->id.'_landingpage')
    @endif

    <script>
      $( document ).ready(function() {
         if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) { 
            $(".layerimage").css('height',450);
            $('#tabnav').hide();
          }
    
          $('#Name, #City').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});
       



if ($(document).width() <= 938) {
$('#bannerim').attr('src',"/images/banner/mobile/<?php echo $list->id; ?>.jpg");
}
else{
    $('#bannerim').attr('src',"/images/banner/<?php echo $list->id; ?>.jpg");
    //$("#bannerim").css("position","absolute");

}

  /* if(jQuery.browser.mobile)
 {

    
   //var bgimage = $( ".layerimage" ).css( "background-image" );
   
    console.log('You are using a mobile device!');
 }
 else{
    $('#bannerim').attr('src',"https://vgn.in/images/banner/<?php //echo $list->id; ?>.jpg");
       $("#bannerim").css("position","absolute");
 }*/

// $( window ).on( "orientationchange", function( event ) {
//   console.log( "This device is in " + event.orientation + " mode!" );
//   window.location.reload();
// });

// if ($(document).width() <= 500) {
//       @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
//          $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/mobile/<?php echo $list->id; ?>.jpg)");
//       @else
//          $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/<?php echo $list->id; ?>.jpg)");
//       @endif
// }
// else{
//   $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/<?php echo $list->id; ?>.jpg)");
// }

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
