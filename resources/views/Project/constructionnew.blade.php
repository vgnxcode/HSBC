@extends('layout.app')

@section('title')
VGN {{ $list->Project_name }} Construction Progress @endsection

@section('description')
<META NAME="Subject" CONTENT="VGN {{ $list->Project_name }} Construction Updates">
<meta name="description" content="VGN {{ $list->Project_name }} Construction Updates">
<meta name="keywords" content="Premium real estate developers in chennai, Leading property developers in chennai, Plots promoters in chennai, Approved plots in ambattur, Approved residential plots in ambattur">
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
          background-color: #fff !important;
          /* color:#000; */
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
    /* background-color: #eee; */
    font-size: 11px;
    /* color: #727272; */
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
    color:#000;
}

/* Add a color on mouse-over */
.enquireform ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}
  
 #imagecard a:link{
  color: #fff;
 }

 #imagecard a:visited{
  color: #fff;
 }

.bread .about-inner {
  margin: 0px 0px 0px 10px
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
    @include('header.index')
@endsection

@section('content')

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
 <section class="root-sec brand-bg" style="text-align:center;">

          @if(Storage::disk('s3')->exists($banner))
           <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$mobile_banner}}">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{ config('app.AWS_URL')}}/{{$banner}}">

          <img src="{{ config('app.AWS_URL')}}/{{$banner}}" alt="<?php echo $projectname_str; ?>" title="<?php echo $projectname_str; ?>">
        </picture>
          @else
          <h2 class="title" style="color: #F44336; text-shadow: 1px 1px 2px #000; font-weight:800;padding-top: 55px;">VGN {{ $list->Project_name }}</h2>
          @endif
          
</section>
@if($list->single_quote != null)
    <section class="root-sec " style="color:#000; padding: 10px;">
  <h2 class="newtitle center-align">{!! $list->single_quote !!}</h2>
</section>
@endif

@if($list->Status == 'Ongoing')
<!-- <section class="root-sec enquireform ">
   

     <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Premium-Real-Estate-Developers-in-Chennai') }}">Ongoing Projects</a></li>
  <li><a href="{{ url('/project/') }}/{{$projectname_str}}">VGN {{$list->Project_name}}</a></li>
  <li>Construction Progress</li>
</ul>
</div>
        </div>
</section> -->
@else
<!-- <section class="root-sec enquireform ">
<div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Chennai-Flat-Builders') }}">Completed Projects</a></li>
  <li><a href="{{ url('/project/') }}/{{$list->id}}">VGN {{$list->Project_name}}</a></li>
  <li>Construction Progress</li>
</ul>
</div>
        </div>
</section> -->
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
                    
                    
                      <h2 class="title" style="color:#000;">Construction Progress</h2>  
                   
                    
                    
                  </div>
                </div>
                <div class="clearfix card-element-wrapper">
                  
                  @foreach($consplanfiles as $k=>$cons)
                                    <?php //$name = str_replace('.jpg','',$cons->getRelativePathName() ) ?>
					<?php  $thumb = str_replace('construction','constructionthumbnail',$cons );

                                    $thumb = pathinfo($thumb, PATHINFO_DIRNAME).'/'.pathinfo($thumb, PATHINFO_FILENAME) . '.' . strtolower(pathinfo($thumb, PATHINFO_EXTENSION));
                                     ?>
                                  
                                  
                                   <div class="col-sm-4 cold-xs-12 single-card-box" >
  <a data-lightbox="image-5"  href="{{ config('app.AWS_URL')}}/{{$cons}}" >
                            <div class="card" style="box-shadow: none">
                              <div class="card-image waves-effect waves-block waves-light">
                                
                                <div class="valign-wrapper card-img-wrap">

                                  <img class="activator" src="{{ config('app.AWS_URL')}}/{{$thumb}}" alt="Construction Images" style="width:300px;height:226px;">
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
       <div class="fab-container hide-on-small-only">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
    </section>
    <!-- #construction images Section end -->

@endif

@endsection

@section('footer')
    @include('footer.index')
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
    //console.log(navigator.userAgent);
         $(".layerimage").css('height',450);
         $('#tabnav').hide();
       }
    
       $('#Name, #City').on('change',function(){
 $(this).val($(this).val().toUpperCase());
});



//if(jQuery.browser.mobile)
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) 
{
 /*
//var bgimage = $( ".layerimage" ).css( "background-image" );
@if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))

 $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/mobile/<?php //echo $list->id; ?>.jpg)");
 @else
   $('.layerimage').css('background-image',"url(http://vgn.in/images/banner/<?php //echo $list->id; ?>.jpg)");
 @endif
console.log('You are using a mobile device!');
*/
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
