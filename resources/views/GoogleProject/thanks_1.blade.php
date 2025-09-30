@extends('layout.app')

@section('title')

 
{{ $list->Project_name }} Thankyou Page
  

@endsection

@section('description')
     
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
@endsection

@section('header')
    @include('landing_header.index')
@endsection

@section('content')

<?php $projectname_str = strtolower(str_replace(' ', '_', $list->Project_name)); ?>

@if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))

 <!-- Banner start -->
    <section id="banner" class="root-sec brand-bg  single-banner blogpage-banner-wrap" style="margin-bottom: 0px;">
    <div class="layerimage" style="background: url({{ asset('/images/banner/')}}/{{$list->id}}.jpg) no-repeat scroll center center / cover;height: 400px;">
    <div class="secinner padd-tb-120" style="height: 100%; width: 100%;">
  @else
  <section id="banner" class="root-sec brand-bg padd-tb-55 single-banner blogpage-banner-wrap" style="margin-bottom: 0px;">

    @endif
      <div class="container">
        <div class="row">
          <div class="clearfix blog-banner-text blog-single-banner">
          @if(file_exists( public_path() . '/images/project_logo/' . $list->id . '.jpg'))
          @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
          <img src="{{ url('/images/project_logo/') }}/{{$list->id}}.jpg" class="img-responsive title imgtitle" style="padding-top: 55px;" alt="Project Logo">
          @endif
          @else

          @if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))
            <div class="col-md-12" style="color: #F44336; font-weight:800;">
            @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
              <h2 class="title" style="color: #F44336; text-shadow: 1px 1px 2px #000;">VGN {{ $list->Project_name }}</h2>
              @endif
              @else
              <div class="col-md-12" >
              @if(file_exists( public_path() . '/images/banner/mobile/' . $list->id . '.jpg'))
          @else
              <h2 class="title">VGN {{ $list->Project_name }}</h2>
              @endif
              @endif
			@endif

@if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))

<!--<ul class="clearfix blog-post-meta">
                <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">{{ $list->Type }}</li>
                <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">{{ $list->Status }} Project</li>
                @if(count($sqftrange) > 0)

                @foreach($sqftrange as $sqft)

                  @if($list->Type == 'Apartments')
                    @if($sqft->End != null)
                    <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">{{$sqft->BHK}} BHK: Starts from {{$sqft->Start}} to {{$sqft->End}} Sq.ft.</li>
                    @else
                    <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">{{$sqft->BHK}} BHK: Starts from {{$sqft->Start}} Sq.ft.</li>
                    @endif
                  @elseif($list->Type == 'Plots')

                    @if($sqft->End != null)
                    <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">Starts from {{$sqft->Start}} to {{$sqft->End}} Sq.ft.</li>
                    @else
                    <li style="border-right:0px; padding:10px;background:#fff;border-radius:3px;font-weight:800;">Starts from {{$sqft->Start}} Sq.ft.</li>
                    @endif

                  @endif

                @endforeach
              
                @endif
                
              </ul>-->

@else

<!--<ul class="clearfix blog-post-meta">
                <li>{{ $list->Type }}</li>
                <li>{{ $list->Status }} Project</li>
                @if(count($sqftrange) > 0)

                @foreach($sqftrange as $sqft)

                  @if($list->Type == 'Apartments')
                    @if($sqft->End != null)
                    <li>{{$sqft->BHK}} BHK: Starts from {{$sqft->Start}} to {{$sqft->End}} Sq.ft.</li>
                    @else
                    <li>{{$sqft->BHK}} BHK: Starts from {{$sqft->Start}} Sq.ft.</li>
                    @endif
                  @elseif($list->Type == 'Plots')

                    @if($sqft->End != null)
                    <li>Starts from {{$sqft->Start}} to {{$sqft->End}} Sq.ft.</li>
                    @else
                    <li>Starts from {{$sqft->Start}} Sq.ft.</li>
                    @endif

                  @endif

                @endforeach
              
                @endif
                
              </ul>-->

@endif

              
                
            </div>
            
          </div>
        </div>
        @if(file_exists( public_path() . '/images/banner/' . $list->id . '.jpg'))
        </div>
        </div>
        @endif
      </div>
    </section> <!-- ./Banner end -->



@if($list->Status == 'Ongoing')
<section class="root-sec enquireform ">
<div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/Real-Estate-Developers-in-Chennai') }}">Ongoing Projects</a></li>
  <li><a href="{{ url('/googlead/project/') }}/{{$projectname_str}}">VGN {{$list->Project_name}}</a></li>
  <li>Thank You</li>
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
  <li><a href="{{ url('/googlead/project/') }}/{{$projectname_str}}">VGN {{$list->Project_name}}</a></li>
  <li>Thank You</li>
</ul>
</div>
        </div>
</section>

@endif
   <section class="root-sec " style="background-color: #EF533B; padding: 10px;">
  <h2 class="newtitle center-align">Thanks for your Enquiry</h2> <h2 class="newtitle center-align"><br><a href="{{ url('/googlead/project/')}}/{{$projectname_str}}" class="btn newwhitewave waves-effect waves-light btn-medium regular-text"><i class="mdi-content-reply left"></i> Go Back</a></h2>
</section>



<section class="root-sec enquireform ">
    <div class="row">
        <div class="container">
            
                 <h2></h2>
            
        </div>
    </div>
</section>








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

    @if(View::exists('pixelcodes.google.'.$list->id.'_thankyou'))
      @include('pixelcodes.google.'.$list->id.'_thankyou')
    @endif

    <script>
      $( document ).ready(function() {
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
@endsection