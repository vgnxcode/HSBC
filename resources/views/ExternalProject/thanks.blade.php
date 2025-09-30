@extends('layout.app')

@section('title')

 
{{ $list->Project_name }} Thankyou Page
  

@endsection

@section('description')
     
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/materialize/css/materialize.min.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" media="screen,projection" />

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

   </style>
<!-- Event snippet for Enquiry Form conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-689958085/oHTBCNvz-cEBEMXZ_8gC'});
</script>
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')

<?php $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name)); ?>

<section style="position:relative;text-align:center;">
      <img src="#" id="bannerim" style="width:100%;"  alt="Project Image">
    </section>




   <section class="root-sec " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">Thanks for your Enquiry</h2> <h2 class="newtitle center-align"><br><a href="{{ url('/extproject/')}}/{{$vendor}}/{{$projectname_str}}" class="btn newwhitewave waves-effect waves-light btn-medium regular-text"><i class="mdi-content-reply left"></i> Go Back</a></h2>
</section>










@endsection



@section('scripts')
    <script src="{{ asset('assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/detectmobilebrowser.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>

  
    <script src="{{ asset('assets/libs/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/materialize/js/materialize.min.js') }}"></script>

    <script src="{{ asset('assets/libs/lightbox2/dist/js/lightbox.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @if(View::exists('pixelcodes.google.'.$list->id.'_thankyou'))
      @include('pixelcodes.google.'.$list->id.'_thankyou')
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
