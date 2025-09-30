@extends('layout.app')

@section('title')
{{ $list->Project_name }} Contruction Progress
@endsection

@section('description')
    
@endsection

@section('keyword')
    
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.transitions.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/blog.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    #construction .lightimage
    {
          background-color: #F44336 !important;
    }
    #construction div.card
  {
    max-height: 230px;
    margin-bottom: 8px;
  }
  #construction .title {
      font-size: 34px;
      
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
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')
<?php $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name)); ?>

 <section style="position:relative;text-align:center;">
      <img src="#" id="bannerim" style="width:100%;"  alt="Project Image">
    </section>
@if($list->single_quote != null)
    <section class="root-sec " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">{{ $list->single_quote }}</h2>
</section>
@endif

@if($list->Status == 'Ongoing')
<section class="root-sec enquireform ">
   

     <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Real-Estate-Developers-in-Chennai') }}">Ongoing Projects</a></li>
  <li><a href="{{ url('/googlead/project/') }}/{{$projectname_str}}">VGN {{$list->Project_name}}</a></li>
  <li>Construction Progress</li>
</ul>
</div>
        </div>
</section>
@else
<section class="root-sec enquireform ">
<div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Chennai-Flat-Builders') }}">Completed Projects</a></li>
  <li><a href="{{ url('/googlead/project/') }}/{{$list->id}}">VGN {{$list->Project_name}}</a></li>
  <li>Construction Progress</li>
</ul>
</div>
        </div>
</section>
@endif

@if(count($consplanfiles) > 0)
  
   <!-- construction images Section end -->
    <section id="construction" class="scroll-section root-sec grey lighten-5 brand-bg">
    <div class="padd-tb-60 lightimage">
      <div class="container">
        <div class="row">
          <div class="blog-inner">
            <div class="col-sm-12 card-box-wrap">
              <div class="row">
                <div class="clearfix section-head blog-text">
                  <div class="col-sm-10">
                    <h2 class="title">Construction Progress</h2>
                    
                  </div>
                </div>
                <div class="clearfix card-element-wrapper">
                  
                  @foreach($consplanfiles as $cons)
                                    <?php $name = str_replace('.jpg','',basename("{{ config('app.AWS_URL')}}/{{$cons}}",'.jpg')) ?>
                  <div class="col-sm-4 cold-xs-12 single-card-box" >
  <a data-lightbox="image-5"  href="{{ config('app.AWS_URL')}}/{{$cons}}" >
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                
                                <div class="valign-wrapper card-img-wrap">

                                  <img class="activator" src="{{ config('app.AWS_URL')}}/{{$cons}}" alt="{{$name}}">
                                </div>
                              </div>
                              
                              
                            </div>
                            </a>
                          </div>
                          @endforeach

                </div>
                
              </div>
            </div>
          </div>
        </div>
        </div>
      </div> <!-- ./container -->
       <div class="fab-container">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
    </section>
    <!-- #construction images Section end -->

@endif

@endsection

@section('footer')
    @include('landing_footer.index')
@endsection

@section('scripts')
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>

  
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>

    <script src="{{ config('app.AWS_URL')}}/assets/libs/lightbox2/dist/js/lightbox.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>

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
$('#bannerim').attr('src',"{{ config('app.AWS_URL')}}/images/banner/mobile/<?php echo $list->id; ?>.jpg");
}
else{
    $('#bannerim').attr('src',"{{ config('app.AWS_URL')}}/images/banner/<?php echo $list->id; ?>.jpg");
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