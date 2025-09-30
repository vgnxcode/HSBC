@extends('layout.app')

@section('title')
VGN: Leading Property Developers in Chennai | Premium Builders in Chennai
@endsection

@section('description')
 
   <META NAME="Subject" CONTENT="Leading property developers in Chennai">
<meta name="description" content="VGN is one of the top leading property developers in Chennai. We offers best premium residential projects with first rated amenities. Call Today ">
<meta name="keywords" content="Plots promoters in chennai, Luxury apartments in chennai, Flats and apartments in chennai, Leading property developers in chennai, Premium builders in chennai ">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Leading property developers in chennai| Premium builders in chennai'/>
<meta property='og:description' content='VGN is one of the top leading property developers in Chennai.We offers best premium residential projects with first rated amenities. Call Today'/>
<meta property='og:url' content='http://vgn.in'/>
<meta property='og:site_name' content='VGN Property Developers Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')
    
    <meta name="google-site-verification" content="RBp1QX3bhBeeKkqM6lrZ-N_9odupFpioOqnbXH3lnYw" />

<meta name="msvalidate.01" content="155FEAF16105EB55703E42B4978154D7" />
    <!--<meta name="google-site-verification" content="qu5hng057mXQ5gHXBgZ3g8ksJQAomQ232osVHv7yOSA" />-->
   
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
  
    <link rel="stylesheet" href="{{ asset('assets/css/colors/color1.css') }}">
    <style>
    .contact-form .materialize-textarea {
      height: 64px !important;
    }
    .modal {
      padding: 0;
     
    }
    .popupimg
    {
      max-width: 400px;
      max-height: 432px;
    }

     .popupimgnew
    {
      max-width: 400px;
      max-height: 432px;
    }

    .title{
		margin-bottom: 0px;
	}
		
		 #mobile_display_socialicons .social-icons li a {
      color: #fff;
    }

.preloader {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background-image: url('/lloader.gif');
   background-repeat: no-repeat; 
   background-color: #f3f3f3;
   background-position: center;
}
    

        
    </style>
	<script type="application/ld+json">
{
	"@context" : "http://schema.org",
	"@type" : "Organization",
	"name" : "VGN Property Developers",
	"url" : "http://www.vgn.in",
	"sameAs" : ["https://www.facebook.com/VGN.India",
		"https://twitter.com/vgndevelopers",
		"https://plus.google.com/u/0/+VGNPropertyDevelopersPvtLimited",
		"https://www.instagram.com/vgn_property_developers/",
		"https://www.youtube.com/user/vgndevelopers",
		"https://www.linkedin.com/company/vgnpropertydevelopers/",
		"https://in.pinterest.com/vgnpropertydevelopers/"]
}
</script>
     <!--Start of vgn developers Zendesk Chat Script-->
<script type="text/javascript">

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	
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
<div class="preloader"></div>
    <div class="owl-carousel" id="owl-demo" style="margin-top: 80px;">
  <a href="/fairmont/Buy-premium-flats-Guindy"><img id="slide1"  src="{{asset('images/sliders_052019/slider01.jpg')}}" class="imgnew" alt="First slide"></a>
  <a href="/notting_hill/Flats-for-sale-nungambakkam"><img id="slide2"  src="{{asset('images/sliders_052019/slider02.jpg')}}" class="imgnew" alt="Second slide"></a>
  <a href="/project/victoria_park"><img id="slide3"  src="{{asset('images/sliders_052019/slider03.jpg')}}" class="imgnew" alt="Third slide"></a>
  <a href="/project/mayfield_park"><img  id="slide4" src="{{asset('images/sliders_052019/slider04.jpg')}}" class="imgnew" alt="Fourth slide"></a>
  <a href="/project/crofton_gardens_phase_ii"><img id="slide5"  src="{{asset('images/sliders_052019/slider05.jpg')}}" class="imgnew" alt="Fifth slide"></a>
</div>
      <section id="home" class="scroll-section root-sec white lighten-5 home-wrap">
      <div class="sec-overlay">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">

          
              <!-- <div class="home-inner"> -->
                <div class="home-inner" style="padding-top: 10px; height: 30px;">

              <!--     <div class="center-align home-content">
                    
                   <img src="{{ asset('/images/mainbanner.png') }}" class="img-responsive" height="360px" alt="Logo">
</div> -->
                     
                    <!-- <div class="row" style="padding-top:15px;padding-bottom: 30px;"> -->
                      <div class="row">
                    <form class="col s12" action="{{ url('/search') }}" method="post">
                      {{ csrf_field() }}
                    <div class="row">
                      
                     <div class="col s10 m3">
                        <select name="location" id="location">
                        <option value="" selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        @if(count($list) >= 1)
                        @foreach($list as $location)
                        @if($location->Location != null)
                        <option value="{{$location->Location}}">{{$location->Location}}</option>
                        @endif
                        @endforeach
                        @endif
                        </select>
                    </div>

                    <div class="col s10 m3">
                        <select name="budget" id="budget">
                        <option value=""  selected>Budget <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        <option value="10L-20L">10 - 20 Lakhs</option>
                        <option value="21L-40L">21 - 40 Lakhs</option>
                        <option value="41L-60L">41 - 60 Lakhs</option>
                        <option value="61L-80L">61 - 80 Lakhs</option>
                        <option value="81L-99L">81 - 99 Lakhs</option>
                        <option value="1C">1 Crore Plus</option>
                        </select>
                    </div>

                     <div class="col s10 m3">
                        <select name="projecttype" id="projecttype">
                        <option value="" selected>Project Type <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        <option value="apartments">Apartments</option>
                        <option value="plots">Plots</option>
                        </select>
                    </div>

                     <div class="col s10 m3">
                        <select name="pstatus" id="pstatus">
                        <option value="" selected>Status <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        <option value="RTC">Ready to Occupy</option>
                        <option value="UC">Under Construction</option>
                        </select>
                    </div>

                    
                    
                    </div>
                    <!--<div class="row">
                      <div class="col s2 m2 pull-right">
                    <button type="submit" class="btn-floating waves-effect waves-light btn-large red white-text" ><i class="mdi-action-search"></i></button>
                    </div>
                    </div>-->
						<div class="row">
                      <div class="col s10 m12 ">
                    <button type="submit" class="btn waves-effect red waves-light btn-small pull-right" style="text-transform: initial;" ><i class="mdi-action-search"></i> Submit</button>
                    </div>
                    </div>
						
                    </form>
                    </div>
                    
                  </div>
              </div>
            </div>
          
        </div>
        <!-- .container end -->
        <div class="section-call-to-area">
          <div class="container">
            <div class="row">
              <a href="#experience" class="btn-floating btn-large button-middle call-to-about section-call-to-btn animated btn-up btn-hidden" data-section="#experience">
                <i class="mdi-navigation-expand-more"></i>
              </a>
            </div>
          </div>
          <!-- .container end -->
        </div>
      </div>
    </section>
    <!-- #home Section end -->

  <!-- featured Section start -->
  
      <section id="experience" class="root-sec brand-bg experience-wrap" style="padding:40px 0px;">
        <div class="container">
          <div class="row">
            <div class="experience-inner">
              <div class="col-sm-12 col-md-10 card-box-wrap">
                <div class="row">
                  <div class="clearfix section-head experience-text">
                    <div class="col-sm-12">
                      <h2 class="title">Featured Projects</h2>
                      <!--<p class="regular-text">The Featured Projects in this section provide an insight into excellent work. Explore this know to learn more about our various projects spanning across various locations.</p> -->
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="overflow-hidden">
                      <div class="row">
                        <div id="experienceSlider" class="clearfix card-element-wrapper">

                       <!--  @foreach($featuredproject as $feature)
                        <?php $projectname_str = strtolower(str_replace(' ', '_', $feature->Project_name)); ?>
                          <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">{{$feature->Type}}</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 @if(file_exists( public_path() . '/images/project_thumb/' . $feature->id . '.jpg'))

                        <img class="activator img-responsive" src="/images/project_thumb/{{$feature->id}}.jpg" alt="{{$feature->Project_name}}">
                      @else
                          @if($feature->Type == 'Apartments')
                          <img class="activator img-responsive" src="/images/project_thumb/default_flats.jpg" alt="{{$feature->Project_name}}">
                          @elseif($feature->Type == 'Plots')
                          <img class="activator img-responsive" src="/images/project_thumb/default_plots.jpg" alt="{{$feature->Project_name}}">
                          @else
                          @endif
                      @endif
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN {{$feature->Project_name}}<i class="mdi-navigation-more-vert right"></i></span>
                                <p>{{$feature->Location}}</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN {{$feature->Project_name}}<i class="mdi-navigation-close right"></i></span>
                                  <p>{{$feature->Type}}</p>
                                </div>
                                
                                  <p class="rev-content">Location: {{$feature->Location}} <br>Status: {{$feature->Status}}</p>
                                  <p class="center-align"><a href="{{ url('/project/') }}/{{$projectname_str}}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>

                          @endforeach -->




                          


                           <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">Apartments</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 

                        <img class="activator img-responsive" src="/images/project_thumb/2.jpg" alt="VGN Notting Hill">
                     
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN Fairmont<i class="mdi-navigation-more-vert right"></i></span>
                                <p>Guindy</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN Fairmont<i class="mdi-navigation-close right"></i></span>
                                  <p>Apartments</p>
                                </div>
                                
                                  <p class="rev-content">Location: Guindy <br>Status: Ongoing</p>
                                  <p class="center-align"><a href="{{ url('/project/fairmont') }}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>
							
							<div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">Apartments</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 

                        <img class="activator img-responsive" src="/images/project_thumb/1.jpg" alt="VGN Notting Hill">
                     
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN Notting Hill<i class="mdi-navigation-more-vert right"></i></span>
                                <p>Nungambakkam</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN Notting Hill<i class="mdi-navigation-close right"></i></span>
                                  <p>Apartments</p>
                                </div>
                                
                                  <p class="rev-content">Location: Nungambakkam <br>Status: Ongoing</p>
                                  <p class="center-align"><a href="{{ url('/project/notting_hill') }}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>
							
							
							<div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">Plots</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 

                        <img class="activator img-responsive" src="/images/project_thumb/118.jpg" alt="VGN Notting Hill">
                     
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN Victoria Park<i class="mdi-navigation-more-vert right"></i></span>
                                <p>Ambattur</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN Victoria Park<i class="mdi-navigation-close right"></i></span>
                                  <p>Plots</p>
                                </div>
                                
                                  <p class="rev-content">Location: Ambattur<br>Status: Ongoing</p>
                                  <p class="center-align"><a href="{{ url('/project/victoria_park') }}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>

                          <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">Plots</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 

                        <img class="activator img-responsive" src="/images/project_thumb/116.jpg" alt="VGN Notting Hill">
                     
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN Mayfield Park<i class="mdi-navigation-more-vert right"></i></span>
                                <p>Tambaram</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN Mayfield Park<i class="mdi-navigation-close right"></i></span>
                                  <p>Plots</p>
                                </div>
                                
                                  <p class="rev-content">Location: Tambaram<br>Status: Ongoing</p>
                                  <p class="center-align"><a href="{{ url('/project/mayfield_park') }}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>

                           

                          <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                            <div class="card">
                              <div class="card-image waves-effect waves-block waves-light">
                                <h2 class="center-align card-title-top">Plots</h2>
                                <div class="valign-wrapper card-img-wrap">
                                 

                        <img class="activator img-responsive" src="/images/project_thumb/115.jpg" alt="VGN Notting Hill">
                     
                                </div>
                              </div>
                              <div class="card-content">
                                <span class="card-title activator brand-text">VGN Crofton Gardens Phase II<i class="mdi-navigation-more-vert right"></i></span>
                                <p>Avadi</p>
                              </div>
                              <div class="card-reveal">
                                <div class="rev-title-wrap">
                                  <span class="card-title activator brand-text">VGN Crofton Gardens Phase II<i class="mdi-navigation-close right"></i></span>
                                  <p>Plots</p>
                                </div>
                                
                                  <p class="rev-content">Location: Avadi<br>Status: Ongoing</p>
                                  <p class="center-align"><a href="{{ url('/project/crofton_gardens_phase_ii') }}" class="btn btn-info btn-large white-text">Click to View</a></p>
                                

                              </div>
                            </div>
                          </div>
                         
                        
                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="btn-wrapp exp-ctrl">
                <a class="btn-floating waves-effect waves-light btn-large white go go-left"><i class="mdi-navigation-chevron-left brand-text"></i></a>
                <a class="btn-floating waves-effect waves-light btn-large white go go-right"><i class="mdi-navigation-chevron-right brand-text"></i></a>
              </div>
            </div>
          </div>
        </div>
      </section>

    <!-- #featured Section end -->




    <!-- Funfacts Section end -->
    <section id="funfacts" class="root-sec grey lighten-5 funfact-wrap">
    <div class="sec-inner" style="padding:40px 0px;">
      <div class="container">
        <div class="row">
          <div class="funfact-inner">
            <div class="col-sm-4 funfact-box">
              <div class="center-align card-panel white">
                <div class="feature-box-outer">
                  <div class="funfact-box-inner">
                    <div class="clearfix ">
                      <i class="fa fa-smile-o" aria-hidden="true"></i>
                      <span class="num countNumb">50000</span>
                    </div>
                    <div class="context">Happy clients</div>
                  </div>
                </div>
              </div>
            </div> <!-- ./single fun fact box -->
            <div class="col-sm-4 funfact-box">
              <div class="center-align card-panel white">
                <div class="feature-box-outer">
                  <div class="funfact-box-inner">
                    <div class="clearfix ">
                      <i class="fa fa-building-o" aria-hidden="true"></i>
                      <span class="num countNumb">{{$completedcount}}</span>
                    </div>
                    <div class="context">Projects Completed</div>
                  </div>
                </div>
              </div>
            </div> <!-- ./single fun fact box -->
            <div class="col-sm-4 funfact-box">
              <div class="center-align card-panel white">
                <div class="feature-box-outer">
                  <div class="funfact-box-inner">
                    <div class="clearfix ">
                      <i class="fa fa-trophy" aria-hidden="true"></i>
                      <span class="num countNumb">47</span>
                    </div>
                    <div class="context">Awards Won</div>
                  </div>
                </div>
              </div>
            </div> <!-- ./single fun fact box -->
          </div>
        </div>

      </div>  <!-- .container end -->
    </div>
    </section>
    <!-- #funfacts Section end -->

      

    <!-- Testimonial Section end -->
    <section id="testimonial" class="scroll-section root-sec testimonial-wrap">
    <div class="sec-inner" style="padding:40px 0px;">
      <div class="container">
        <div class="row">
          <div class="testimonial-inner">
            <div class="col-sm-12 col-md-10 card-box-wrap">
              <div class="row">
                <div class="clearfix section-head testimonial-text">
                  <div class="col-sm-12">
                    <h2 class="title">Testimonials</h2>
                    <p class="regular-text">See what some of our prestigious clients say about us. Customer satisfaction metric very useful in managing and monitoring our businesses. </p>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="overflow-hidden">
                    <div class="row">
                      <div id="testimonialSlider" class="clearfix card-element-wrapper">
                      @foreach($testimonials as $testimon)
                        <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                          <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                              <div class="card-img-wrap">
                                <img class="activator" src="{{ asset('images/testimonial/') }}/{{$testimon->image}}" alt="{{$testimon->name}}">
                                <p class="saying-about">{{$testimon->testimonials}}</p>
                              </div>
                            </div>
                            <div class="card-content">
                              <span class="card-title activator brand-text">{{$testimon->name}} </span>
                            </div>
                          </div>
                        </div> <!-- ./single testimonial box -->
                     @endforeach
                      </div> <!-- #testimonialSlider end -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="btn-wrapp tmo-ctrl">
              <a class="btn-floating waves-effect waves-light btn-large white go go-left"><i class="mdi-navigation-chevron-left brand-text"></i></a>
              <a class="btn-floating waves-effect waves-light btn-large white go go-right"><i class="mdi-navigation-chevron-right brand-text"></i></a>
            </div>
          </div>
        </div>
      </div> <!-- ./container end -->
    </div>
    </section>
    <!-- #testimonial Section end -->
<section id="mobile_display_socialicons">
<div class="row" >
                    <div class="wrapper text-center">
                      <ul class="center social-icons footerinline-menu footerside-nav"> 
                        <li><a href="https://www.facebook.com/VGN.India" class="tooltips tooltipped facebook" data-position="top" data-delay="50" data-tooltip="Facebook"><i class="fa fa-facebook"></i></a>
                </li>
                <li><a href="https://twitter.com/vgndevelopers" class="tooltips tooltipped twitter" data-position="top" data-delay="50" data-tooltip="Twitter"><i class="fa fa-twitter"></i></a>
                </li>
                <li><a href="https://www.youtube.com/user/vgndevelopers" class="tooltips tooltipped youtube" data-position="top" data-delay="50" data-tooltip="Youtube"><i class="fa fa-youtube"></i></a>
                </li>
                <li><a href="https://www.instagram.com/vgn_property_developers/" class="tooltips tooltipped instagram" data-position="top" data-delay="50" data-tooltip="Instagram"><i class="fa fa-instagram"></i></a>
                </li>
                <li><a href="https://in.pinterest.com/vgndevelopers/" class="tooltips tooltipped pinterest" data-position="top" data-delay="50" data-tooltip="Pinterest"><i class="fa fa-pinterest-square"></i></a>
                </li>
                <li><a href="https://www.linkedin.com/company/vgnpropertydevelopers/" class="tooltips tooltipped linkedin" data-position="top" data-delay="50" data-tooltip="Linkedin"><i class="fa fa-linkedin-square"></i></a>
                </li>
                <li><a href="https://plus.google.com/+VGNPropertyDevelopersPvtLimited" class="tooltips tooltipped google-plus" data-position="top" data-delay="50" data-tooltip="Google Plus"><i class="fa fa-google-plus-square"></i></a>
                </li>
         
      </ul>
        </div>
                  </div>
      </section>
    <!-- Contact Section end -->
    <section id="contact" class="scroll-section root-sec brand-bg contact-wrap" style="padding:40px 0px;">
 <div class="fab-container hide-on-small-only">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
      <div class="container">
        
        <div class="row">
          <div class="contact-inner">
            <div class="col-sm-12 card-box-wrap">
              <div class="row">
                <div class="clearfix section-head contact-text">
                  <div class="col-sm-12">
                    <h2 class="title">Contact</h2>
                    <p class="regular-text">No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.</p>

                     <ul class="clearfix contact-info">
                                            
                      <li><a href="tel:04443439900">Phone - 044 43439900</a>
                      </li>
                      <li><a href="tel:04443439999" id="calllink">For Sales Enquiry - 044 43439999</a>
                    </ul>
                    <!-- <p><a href="https://goo.gl/maps/8voC4NHXFoyL5bh78" class="btn btn-warning regular-text" style="text-transform: initial; background-color: #F44336;padding-right: 8px;padding-left: 8px;"> <i class="fa fa-map-marker"></i> View On Map</a></p> -->
                  </div>
					 <div class="row" id="mobile_display_socialicons">
                    <div class="wrapper">
                      <ul class="social-icons icon-circle icon-rotate list-unstyled list-inline hide-on-large-only"> 
                        <li> <a href="https://www.facebook.com/VGN.India"><i class="fa fa-facebook"></i></a></li> 
                        <li> <a href="https://twitter.com/vgndevelopers"><i class="fa fa-twitter"></i></a></li> 
                        <li> <a href="https://www.youtube.com/user/vgndevelopers"><i class="fa fa-youtube"></i></a></li>
                        <li> <a href="https://www.instagram.com/vgn_property_developers/"><i class="fa fa-instagram"></i></a></li> 
                        <li> <a href="https://in.pinterest.com/vgndevelopers/"><i class="fa fa-pinterest"></i></a></li> 
                        <li> <a href="https://www.linkedin.com/company/vgnpropertydevelopers/"><i class="fa fa-linkedin"></i></a></li> 
                        
         
      </ul>
        </div>
                  </div>
                </div> <!-- contact text end -->

                <div class="clearfix contact-form">

                <!-- Map Start
                  <div class="col-sm-8 col-sm-offset-2">
                    <div class="map-wrapper">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.589782826173!2d80.24716671425331!3d13.061763190796727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526669868471cf%3A0x6c9abb4bc5649a04!2sVGN+Property+Developers+Private+Limited!5e0!3m2!1sen!2s!4v1494933195711" frameborder="0" style="border:0" id="map" allowfullscreen="" class="img-responsive col-md-12 googlemap"></iframe>
                    </div>
                  </div> <!-- Map end -->

                 

                
                </div>



              </div>
            </div>
          </div>
        </div>


        <a href="https://goo.gl/maps/sNyL8CLmpRbrFoWi7" >
     <div class="col-sm-12" style="background: url(https://vgn.in/vgngooglemap.PNG); height: 300px;background-repeat:no-repeat;
background-position: center center; padding: 10px;" >
                  </div></a>
                  <br>
      </div> <!-- ./container end -->
     

    
    </section>

    

      <!-- Modal Structure -->
     <div id="modal1">
        <div class="modal-footer modal popupimgnew " style="z-index: 10001; text-align: right; background: transparent;box-shadow: none;">
      <a href="#!" class="newmodal modal-action modal-close"><img src="{{ url('/images/close.png') }}"></a>
    </div>
    <a href="{{ url('/project/17')}}">
      <img src="{{ asset('images/popup/image.jpg') }}" alt="pop up" class="modal img-responsive popupimg">    
    </a>
      
    
    </div>
  

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
    
<script>
  $(window).load(function() {
   $('.preloader').fadeOut('slow');
});

 $(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  /*owl.owlCarousel({
    autoPlay : 6000,
    navigation : false,
    singleItem : true,
    transitionStyle : "fade",
    responsive: true
  });*/

  owl.owlCarousel({
    autoPlay : 5000,
    animateOut: 'slideOutDown',
    animateIn: 'scroll',
    navigation : false,
    singleItem : true,
    items:1,
    margin:30,
    stagePadding:30,
    smartSpeed:450
  });


  if ($(document).width() <= 938) {
$('#slide1').attr('src',"/images/banner/mobile/2.jpg");
$('#slide2').attr('src',"/images/banner/mobile/1.jpg");
$('#slide3').attr('src',"/images/banner/mobile/118.jpg");
$('#slide4').attr('src',"/images/banner/mobile/116.jpg");
$('#slide5').attr('src',"/images/banner/mobile/115.jpg");
}
else{
    $('#slide1').attr('src',"/images/sliders_052019/slider01.jpg");
    $('#slide2').attr('src',"/images/sliders_052019/slider02.jpg");
    $('#slide3').attr('src',"/images/sliders_052019/slider03.jpg");
    $('#slide4').attr('src',"/images/sliders_052019/slider04.jpg");
    $('#slide5').attr('src',"/images/sliders_052019/slider05.jpg");
    //$("#bannerim").css("position","absolute");

}

	 
});
</script>
<script>
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
$("#mobile_display_socialicons").show();
  $("body").on('click', function(){
    $("#dropdown1").hide();
    $("#dropdown2").hide();
	$("#dropdown3").hide();
  });
}
else
{
  $("#mobile_display_socialicons").hide();
}
</script>

@endsection