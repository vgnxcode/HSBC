@extends('layout.app')

@section('title')
VGN:Premium real estate developers in chennai| Flat builders in chennai
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Premium real estate developers in chennai">
<meta name="description" content="VGN premium real estate builders and developers offers world class residential properties like flats,apartments across all localities in Chennai.">
<meta name="keywords" content="Premium flats in guindy, Luxury apartments for sale in guindy, Luxury apartments in ecr, Premium real estate developers in chennai, Flat builders in chennai">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Premium real estate developers in chennai| flat builders in chennai'/>
<meta property='og:description' content='VGN premium real estate builders and developers offers world class residential properties like flats,apartments across all localities in Chennai.'/>
<meta property='og:url' content='http://vgn.in/Premium-Real-Estate-Developers-in-Chennai'/>
<meta property='og:site_name' content='VGN Property Developers Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')
    
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

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
  
    <link rel="stylesheet" href="{{ asset('assets/css/colors/color1.css') }}">
    <style>
    #portfolio div.card-img-wrap {
      min-height: 342px;
    }

 div.portfolio-top {
      padding-top: 20px;
    }
    
    #portfolio ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    background-color: #eee;
    font-size: 11px;
    color: #727272;
    text-transform: uppercase;
    
}

/* Display list items side by side */
#portfolio ul.breadcrumb li {
    display: inline;
}

/* Add a slash symbol (/) before/behind each list item */
#portfolio ul.breadcrumb li+li:before {
    padding: 8px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
#portfolio ul.breadcrumb li a {
    text-decoration: none;
}

/* Add a color on mouse-over */
#portfolio ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}

.bread .about-inner {
  margin: 0px 0px 10px 10px
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

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '219397791799568'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=219397791799568&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


    <!-- Banner start -->
    <section id="banner" class="root-sec brand-bg padd-tb-73 blogpage-banner-wrap" style="margin-bottom: 0px; padding-bottom: 0px;">
      <div class="container">
        <div class="row">
          <div class="clearfix blog-banner-text">
            <div class="col-sm-8 col-md-8 col-lg-8">
              <h2 class="title">Ongoing Projects</h2>
              <p class="regular-text">This webpage contains the apartments and plots of ongoing projects</p>
            </div>
          </div>
        </div>
      </div>
    </section> <!--./Banner end-->


<!-- Portfolio Section start -->
    <section id="portfolio" class="scroll-section root-sec white portfolio-wrap">
      <div class="padd-tb-120 brand-bg portfolio-top" style="padding-top: 30px;">
        <div class="portfolio-inner">
           <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li>Ongoing Projects</li>
</ul>
</div>
        </div>
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
               
                <ul class="inline-menu clearfix portfolio-category" id="portfolio-msnry-sort">
                  <li class="active"><a href="#" data-target="*">All</a>
                  </li>
                  <li><a href="#" data-target=".Apartments-1">Apartments</a>
                  </li>
                  <li><a href="#" data-target=".Plots-1">Plots</a>
                  </li>
                 
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- .container end -->
      </div>
      

      <div class="portfolio-bottom">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <ul class="clearfix protfolio-item" id="protfolio-msnry">
              
              @if(count($list) > 0)
              @foreach($list as $ongoing)
<?php $projectname_str = strtolower(str_replace(' ', '_', $ongoing->Project_name)); ?>
              
              <!-- Single Portfolio-->
                <li class="col-sm-6 col-md-4 single-port-item {{$ongoing->Type}}-1">

                <article class="single-card-box single-post">
              <div class="card marginrightzero">
                <div class="card-image">
                  <div class="card-img-wrap">
                    <div class="blog-post-thumb waves-effect waves-block waves-light">
                    @if($ongoing->no_details != null)
                    <a href="#">
                    @else
                    <a href="{{ url('/project')}}/{{$projectname_str}}">
                    @endif
                      
                     
                       @if(file_exists( public_path() . '/images/project_thumb/' . $ongoing->id . '.jpg'))

                        <img class="activator img-responsive" src="/images/project_thumb/{{$ongoing->id}}.jpg" alt="{{$ongoing->Project_name}}">
                      @else
                          @if($ongoing->Type == 'Apartments')
                          <img class="activator img-responsive" src="/images/project_thumb/default_flats.jpg" alt="{{$ongoing->Project_name}}">
                          @elseif($ongoing->Type == 'Plots')
                          <img class="activator img-responsive" src="/images/project_thumb/default_plots.jpg" alt="{{$ongoing->Project_name}}">
                          @else
                          @endif
                      @endif
                  
                      </a>
                    </div>
                    <div class="post-body">
                    @if($ongoing->no_details != null)
                    <a href="#" class="post-title-link brand-text"><h2 class="post-title">VGN {{$ongoing->Project_name }}</h2></a>
                    @else
                    <a href="{{ url('/project')}}/{{$projectname_str}}" class="post-title-link brand-text"><h2 class="post-title">VGN {{$ongoing->Project_name }}</h2></a>
                    @endif
                      
                      @if($ongoing->Location != null)
                      <p class="post-content">Location: {{ $ongoing->Location }}</p>
                      @endif
                      @if($ongoing->Type != null)
                      <p class="post-content">Project Type: {{ $ongoing->Type }}</p>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="clearfix card-content">
                  @if($ongoing->no_details != null)
                  <a href="#" class="brand-text right waves-effect">MORE DETAILS</a>
                  @else
                  <a href="{{ url('/project')}}/{{$projectname_str}}" class="brand-text right waves-effect">MORE DETAILS</a>
                  @endif
                </div>
              </div>
            </article> <!--./single blog post-->
                                    
                </li>
                <!--/ single portfolio -->
            @endforeach
                @endif
               

              </ul>
              
            </div>
          </div>
        </div>
      </div>

       <div class="fab-container">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
    </section>
    <!-- #portfolio Section end -->


@endsection

@section('footer')
    @include('footer.index')
    <!-- Google Code for Remarketing Tag -->

<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 864630853;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/864630853/?guid=ON&amp;script=0"/>
</div>
</noscript>
@endsection

@section('scripts')
    <script src="{{ asset('assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/detectmobilebrowser.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
  
    <script src="{{ asset('assets/libs/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection