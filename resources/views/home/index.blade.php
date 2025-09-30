@extends('layout.app')

@section('title')
VGN Projects Estates
@endsection

@section('description')
 
   <META NAME="Subject" CONTENT="Leading property developers in Chennai">
<meta name="description" content="VGN - We are one of the leading Real Estate Developers in Chennai offering Premium apartments, flats and plots for sale with best in class amenities">
<meta name="keywords" content="VGN Projects Estates, New Apartment Projects In Chennai, Best Residential Projects In Chennai, Best Plot Promoters In Chennai, Residential Projects In Chennai, Premium Real Estate Developers In Chennai, Leading Property Developers In Chennai, Premium Builders In Chennai, Flat Builders In Chennai, Best Apartment Builders In Chennai, Plots Promoters In Chennai, Best Flat Promoters In Chennai,VGN projects Estates Pvt.Ltd,VGN projects Estates Private Limited,VGN Infra India,VGN Home Building,VGN developers,VGN property developers,VGN interiors,VGN Facility management,VGN Builders,VGN real Estate">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Leading Property Developers in Chennai - VGN Projects Estates Pvt. Ltd.'/>
<meta property='og:description' content='VGN Projects Estates - We are one of the leading Real Estate Developers in Chennai offering Premium apartments, flats and plots for sale with best in class amenities'/>
<meta property='og:url' content='{{ url()->full() }}'/>
<meta property='og:site_name' content='VGN Projects Estates Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')
    
    <meta name="google-site-verification" content="RBp1QX3bhBeeKkqM6lrZ-N_9odupFpioOqnbXH3lnYw" />

<meta name="msvalidate.01" content="155FEAF16105EB55703E42B4978154D7" />
   
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize_new/css/newmaterialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

    
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
    <!-- <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.transitions.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.css" media="screen,projection" /> -->
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min_new.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.default.min_new.css" media="screen,projection" />
    
    
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">

  <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/assets/libs/slick-1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/assets/libs/slick-1.8.1/slick/slick-theme.css"/>

    <style>

      .slider .slides li {
    opacity: 0.2;
}

      .testimonial-inner .card-img-wrap:after{
        color: #fff;
      }

.dropdown-content{
  min-width: 170px !important;
}

.select-wrapper input.select-dropdown {
    color: #F44336 !important;
    border-bottom: 1.5px solid #F44336 !important;
}

.dropdown-content li a{
  text-align: left;
  padding-left: 20px !important;
}
      .dropcss li a {
    font-size: 75%;
    padding: 15px;
    border-bottom: 3px solid transparent;
    background-color: transparent;
    -webkit-transition: all .3s ease-out;
    transition: all .3s ease-out;
    color: #F44336 !important;
}

    .sside-nav li a {
    padding: 25px;
    line-height: 24px;
    -webkit-transition: all .3s ease-out;
    transition: all .3s ease-out;
    color: #000;
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 500;
}
    .contact-form .materialize-textarea {
      height: 64px !important;
    }
    .modal {
      padding: 0;
     
    }

    #popup {
    display:none;
    position:fixed;
    z-index: 10001;
    margin:0 auto;
    max-width: 450px;
    min-width: 300px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0px 0px 50px 2px #000;
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

     .slider {
   width: 100%;
      height: auto;
       
    }
    
    .preloader {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background-image: url(//cdn.vgn.in/Rolling.gif);
   background-repeat: no-repeat; 
   background-color: #ffffff;
   background-position: center;
}
select.browser-default{
  margin: 5px auto;
  color: #F44336;
  border: 1.5px solid #F44336 !important;
  box-shadow: 2px 2px 4px #a2a2a2;
}

@media only screen and (max-width: 479px){
.home-inner {
    min-height: 300px;
    }
  } 
.slider .slides{
    background-color: #fff;
  }

  .spacepara
{
    line-height: 25px;
    margin-bottom: 15px;
}

.imgpop a{
    /* border: 1px solid blue; */
    width: 24%;
    height: 34%;
    position: absolute;
    cursor: pointer;
}
.fairmont{
  top: 27%;
  left: 7%;
}
.coasta{
  top: 27%;
  left: 38%;
}
.notting_hill{
  top: 27%;
  left: 70%;
}
.stafford{
  top: 63.5%;
  left: 22%;
}
.temple_town{
  top: 63.5%;
  left: 57%;
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
.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span{
  background: #ee6e73;
}

    </style>
  <script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "VGN Property Developers",
  "url" : "{{ url()->full() }}",
  "sameAs" : ["https://www.facebook.com/VGN.India",
    "https://twitter.com/vgndevelopers",
    "https://plus.google.com/u/0/+VGNPropertyDevelopersPvtLimited",
    "https://www.instagram.com/vgn_property_developers/",
    "https://www.youtube.com/user/vgndevelopers",
    "https://www.linkedin.com/company/vgnpropertydevelopers/",
    "https://in.pinterest.com/vgnpropertydevelopers/"]
}
</script>
@endsection

@section('header')
    @include('header.index_new')
@endsection

@section('content')
   
    
<section style="margin-top: 80px; padding-top: 1px;">
  <div class="owl-carousel owl-theme">
    <div class="item" data-merge="6">
      <a href="/project/fairmont">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/fairmont_mobileslider_20210703.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/fairmont_mainslider_20210703.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/fairmont_mainslider_20210703.jpg" alt="VGN Fairmont" title="VGN Fairmont">
        </picture>
      </a>
    </div>
    <div class="item" data-merge="6">
      <a href="/project/notting_hill">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/nottinghill_mobileslider_20210731.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/nottinghill_mainslider_20210731.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/nottinghill_mainslider_20210731.jpg" alt="VGN Notting Hill" title="VGN Notting Hill">
        </picture>
      </a>
    </div>
    <div class="item" data-merge="6">
      <a href="/project/varnabhoomi_phase_ii">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/varnabhoomiph2_mobileslider_20210424.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/varnabhoomiph2_slider_20210424.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/varnabhoomiph2_slider_20210424.jpg" alt="VGN Varnabhoomi Phase II" title="VGN Varnabhoomi Phase II">
        </picture>
      </a>
    </div>
    <div class="item" data-merge="6">
      <a href="/project/coasta">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/coasta_mobileslider_23032022.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/VGN-Coasta_23032022.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/VGN-Coasta_23032022.jpg" alt="VGN Coasta" title="VGN Coasta">
        </picture> 
      </a>
    </div>
    <div class="item" data-merge="6">
      <a href="/project/mayfield_park">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/mayfield_park_mobileslider_20210330.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mayfield_park_slider_20210330.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/mayfield_park_slider_20210330.jpg" alt="VGN Mayfield Park" title="VGN Mayfield Park">
        </picture>
      </a>
    </div>
    <div class="item" data-merge="6">
      <a href="/project/temple_town">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/mobile/TT_mobileslider_23032022.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="{{config('app.AWS_URL')}}/images/slider17052019/VGN-TT_23032022.jpg">
          <img src="{{config('app.AWS_URL')}}/images/slider17052019/VGN-TT_23032022.jpg" alt="VGN Temple Town" title="VGN Temple Town">
        </picture>
      </a>
    </div>
  </div>
  <!-- <div class="slider"><div class="preloader"></div><ul class="slides" ><li id="firstli"><a href="/project/fairmont"><img src="#" id="slidetag1" alt="VGN Fairmont"></a></li></ul></div> -->
</section>
<section id="home" class="scroll-section root-sec white lighten-5 home-wrap">
  <div class="sec-overlay">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="home-inner" style="padding-top: 10px; height: 30px;">
            <div class="row">
              <h4 class="pull-left" style="font-weight: 400; color: #F44336; font-size: 26px; text-transform: uppercase;">
                <i class="fa fa-search"></i> Search
              </h4>
            </div>
            <br>
            <div class="row">
              <form class="col s12 form-inline" action="{{ url('/search') }}" method="post"> @csrf <div class="row">
                  <div class="col s10 m4">
                    <select class="browser-default" name="projecttype" id="projecttype">
                      <option value="" selected>Project Type <i class="fa fa-caret-up fa-fw pull-right"></i>
                      </option>
                      <option value="apartments">Apartments</option>
                      <option value="plots">Plots</option>
                    </select>
                  </div>
                  <div class="col s10 m4">
                    <select class="browser-default" name="location" id="location">
                      <option value="" selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i>
                      </option> @if(count($list) > 0) @foreach($list['Location'] as $loc) <option value="{{$loc}}">{{$loc}}</option> @endforeach @endif
                    </select>
                  </div>
                  <div class="col s10 m4">
                    <select class="browser-default" name="budget" id="budget">
                      <option value="" selected>Budget <i class="fa fa-caret-up fa-fw pull-right"></i>
                      </option>
                      <option value="10L-20L">10 - 20 Lakhs</option>
                      <option value="21L-40L">21 - 40 Lakhs</option>
                      <option value="41L-60L">41 - 60 Lakhs</option>
                      <option value="61L-80L">61 - 80 Lakhs</option>
                      <option value="81L-99L">81 - 99 Lakhs</option>
                      <option value="1C">1 Crore Plus</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s10 m12 ">
                    <br>
                    <button type="submit" class="btn waves-effect red waves-light btn-small pull-right" style="text-transform: initial;">
                      <i class="mdi-action-search"></i> Submit </button>
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
            <i class="fa fa-caret-down" style="color: #F44336;"></i>
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
  <div class="container ">
    <div class="row">
      <div class="experience-inner">
        <div class="col-sm-12 col-md-10 card-box-wrap">
          <div class="row">
            <div class="clearfix section-head experience-text">
              <div class="col-sm-12">
                <h2 class="title">Featured Projects</h2>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="overflow-hidden">
                <div class="row">
                  <div class="experienceSlider_1 clearfix card-element-wrapper">
                    <!--  @foreach($featuredproject as $feature)
                        <?php $projectname_str = strtolower(str_replace(' ', '_', $feature->Project_name));?>

                          @endforeach -->
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/fairmont">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Apartments</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{config('app.AWS_URL')}}/images/project_thumb/2/2_03072021.jpg" alt="VGN Fairmont">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Fairmont <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Guindy</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Fairmont <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Apartments</p>
                            </div>
                            <p class="rev-content">Location: Guindy <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/fairmont') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/notting_hill">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Apartments</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{config('app.AWS_URL')}}/images/project_thumb/1/1_03072021.jpg" alt="VGN Notting Hill">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Notting Hill <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Nungambakkam</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Notting Hill <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Apartments</p>
                            </div>
                            <p class="rev-content">Location: Nungambakkam <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/notting_hill') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/varnabhoomi_phase_ii">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Plots</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{ config('app.AWS_URL')}}/images/project_thumb/130/130_24042021.jpg" alt="VGN Varnabhoomi">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Varnabhoomi Phase II <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Pudupakkam</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Varnabhoomi Phase II <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Plots</p>
                            </div>
                            <p class="rev-content">Location: Pudupakkam <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/varnabhoomi_phase_ii') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/coasta">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Apartments</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{ config('app.AWS_URL')}}/images/project_thumb/5/5_20092021.jpg" alt="coasta">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Coasta <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Muttukadu ECR</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Coasta <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Apartments</p>
                            </div>
                            <p class="rev-content">Location: Muttukadu ECR <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/coasta') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/temple_town">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Apartments</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{config('app.AWS_URL')}}/images/project_thumb/14/14_24092021.jpg" alt="Temple Town">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Temple Town <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Thiruverkadu</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Temple Town <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Apartments</p>
                            </div>
                            <p class="rev-content">Location: Thiruverkadu <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/temple_town') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/ch40">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Plots</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{config('app.AWS_URL')}}/images/project_thumb/120/120_04052021.jpg" alt="VGN CH40">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN CH40 <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Anna Nagar</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN CH40 <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Plots</p>
                            </div>
                            <p class="rev-content">Location: Anna Nagar <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/ch40') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-4 cold-xs-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                      <a href="/project/mayfield_park">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <h2 class="center-align card-title-top">Plots</h2>
                            <div class="valign-wrapper card-img-wrap">
                              <img class="activator img-responsive" src="{{config('app.AWS_URL')}}/images/project_thumb/116/116_30032021.jpg" alt="VGN Mayfield Park">
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">VGN Mayfield Park <i class="mdi-navigation-more-vert right"></i>
                            </span>
                            <p>Tambaram</p>
                          </div>
                          <div class="card-reveal">
                            <div class="rev-title-wrap">
                              <span class="card-title activator brand-text">VGN Mayfield Park <i class="mdi-navigation-close right"></i>
                              </span>
                              <p>Plots</p>
                            </div>
                            <p class="rev-content">Location: Tambaram <br>Status: Ongoing </p>
                            <p class="center-align">
                              <a href="{{ url('/project/mayfield_park') }}" class="btn btn-info btn-large white-text">Click to View</a>
                            </p>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="btn-wrapp exp-ctrl">
          <a class="btn-floating waves-effect waves-light btn-large white go go-left">
            <i class="fa fa-caret-left" style="color: #F44336;"></i>
          </a>
          <a class="btn-floating waves-effect waves-light btn-large white go go-right">
            <i class="fa fa-caret-right" style="color: #F44336;"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- #featured Section end -->
<!-- Funfacts Section end -->
<section id="funfacts" class="root-sec grey lighten-5 funfact-wrap">
  <div class="sec-inner" style="padding:10px 0px;">
    <div class="container">
      <div class="row">
        <div class="funfact-inner">
          <div class="col-sm-4 funfact-box">
            <div class="center-align card-panel white">
              <div class="feature-box-outer">
                <div class="funfact-box-inner">
                  <div class="clearfix ">
                    <i class="fa fa-smile-o" aria-hidden="true"></i>
                    <span class="num countNumb">60000</span>
                  </div>
                  <div class="context">Happy clients</div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./single fun fact box -->
          <div class="col-sm-4 funfact-box">
            <div class="center-align card-panel white">
              <div class="feature-box-outer">
                <div class="funfact-box-inner">
                  <div class="clearfix ">
                    <i class="fa fa-building-o" aria-hidden="true"></i>
                    <span class="num countNumb">200</span>
                  </div>
                  <div class="context">Projects Completed</div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./single fun fact box -->
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
          </div>
          <!-- ./single fun fact box -->
        </div>
      </div>
    </div>
    <!-- .container end -->
  </div>
</section>
<!-- #funfacts Section end -->
<section id="testimonial" class="scroll-section root-sec testimonial-wrap" style="padding-top: 0px;padding-bottom: 0px;">
  <div class="sec-inner" style="padding:0px 0px;">
    <div class="container">
      <div class="row">
        <div class="testimonial-inner">
          <div class="col-sm-12 col-md-10 card-box-wrap">
            <div class="row">
              <div class="clearfix section-head testimonial-text">
                <div class="col-sm-12">
                  <h2 class="title">Testimonials</h2>
                  <p class="regular-text">Here is what some of our prestigious clients have to say about us. Customer satisfaction is a very useful metric in managing and monitoring our business. </p>
                </div>
              </div>
              <div class="col-lg-12" style="padding-left: 2px; padding-right: 2px;">
                <div>
                  <button type="button" class="testimslider_left fab btn-floating btn-small red pull-left" style="left: 2px; top: 150px;">
                    <i class="fa fa-arrow-left"></i>
                  </button>
                  <button type="button" class="testimslider_right btn-floating btn-small red pull-right" style="right: 2px; top: 150px;">
                    <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
                <div class="overflow-hidden">
                  <div class="row">
                    <div class="centerscrollslider">
                      <div class="col-sm-12 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/1_Pic.jpg" alt="Mr. Subramanian (Proud Customer of VGN Notting Hill, Nungambakkam)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"Dear CRM Team, <div class="spacepara"></div> I honestly appreciate the excellent service provided during the post-sales process by VGN Customer <span class="final_readmore_toshowhide1" style="display: none;">Care team. <div class="spacepara"></div>They were always Polite, Courteous, and Prompt in responding to telephone calls and mails. Besides they are meticulous in attending to all points raised during discussions." </span>
                                  <a href="javascript:" id="readmoreid1" class="readmoreclass1" onclick="readmore(this,1)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. Subramanian (Proud Customer of VGN Notting Hill, Nungambakkam)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/3_Pic.jpg" alt="Vijayalakshmi (Proud Customer of VGN Oval Gardens, Ambattur)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"Hello CRM and Sales Team, <div class="spacepara"></div> I am happy that the registration of my Plot no: 105 in VGN Oval Garden was successfully done on <span class="final_readmore_toshowhide3" style="display: none;">5th Mar, 2020. <div class="spacepara"></div>We are impressed with your professionalism and way of handling the customer. Listening to our queries / concern and giving explanation in proper manner are awesome. We would like to thank both of you and very much appreciate your coordination to ensure the registration is done smoothly. <div class="spacepara"></div>I would say VGN CRM Team is a classic example / role model for how to handle customer queries in proper way and make Customer satisfied. Once again a Great Thanks to Sales & CRM Team for their wonderful service!!! Keep up your good work." </span>
                                  <a href="javascript:" id="readmoreid3" class="readmoreclass3" onclick="readmore(this,3)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mrs. Vijayalakshmi (Proud Customer of VGN Oval Gardens, Ambattur) </span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/4_Pic.jpg" alt="R.Mohan  (Proud Customer of VGN Coasta, ECR)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"CRM Team, <div class="spacepara"></div> Whenever I visit VGN Coasta, I see the Labours and engineers are working hard day & night to complete the project <span class="final_readmore_toshowhide4" style="display: none;">soon. Here I wish to say the Customer care team of VGN are extremely nice, and very understanding to the crux of the subject, and their prompt responses makes me very happy and replies are to the point balancing the VGN management and the Customer point of view, which I see very few in my vast experience in the Customer management field. Here again, I need to add that the Sales and Marketing of VGN Coasta are also excellent in convincing me to buy a flat. As for as I am concerned I see very efficient customer care attention has been given, and I give 5/5 Star for their service."</span>
                                  <a href="javascript:" id="readmoreid4" class="readmoreclass4" onclick="readmore(this,4)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. R.Mohan (Proud Customer of VGN Coasta, ECR)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/5_Pic.jpg" alt="Mr. Amit jyothi (Proud Customer of VGN Stafford, Ambattur)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"At the outset, we wish to congratulate VGN and its team for their wonderful project and services. I bought an apartment in VGN STAFFORD, Thirumullaivoyal, Ambattur and was taken aback by the excellent <span class="final_readmore_toshowhide5" style="display: none;">way the transaction was completed. I must say the level of transparency and quality of resources is excellent. VGN sales and customer care has been on constant follow up, regularly updated me on the various processes stage by stage, especially customer care team is extremely efficient and I thought it’s important for me to applaud their sincerity. The entire experience was a quite touching and sweet memory. Club house was excellent. <div class="spacepara"></div>It was a right decision to have invested in VGN Stafford. <div class="spacepara"></div>Overall it was an excellent work done by VGN people to get me a dream home. <div class="spacepara"></div>Keep up the good work." </span>
                                  <a href="javascript:" id="readmoreid5" class="readmoreclass5" onclick="readmore(this,5)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. Amit jyothi (Proud Customer of VGN Stafford, Ambattur)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/6_Pic.jpg" alt="Mr. Deenadayalan (Proud Customer of VGN Cosmopolis, Ambattur)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"Thank you for your dedication and support throughout the process right from booking a plot till completion of sale deed registration and handing over <span class="final_readmore_toshowhide6" style="display: none;">documents. We are extremely grateful to the entire sales and customer care team for helping us to invest in a prime property VGN Cosmopolis in Ambattur. I have not seen any large parcels of land within Chennai Corporation limits and very close to city. <div class="spacepara"></div>We successfully completed the registration process yesterday and I would like to thank each one of you at this moment for your great support, flexibility and cooperation for achieving this final milestone." </span>
                                  <a href="javascript:" id="readmoreid6" class="readmoreclass6" onclick="readmore(this,6)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. Deenadayalan (Proud Customer of VGN Cosmopolis, Ambattur)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/7_Pic.jpg" alt="Mr. Thomas  (Proud Customer of VGN Temple Town,Thiruverkadu)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"It is indeed a matter of prestige to own an apartment in VGN Temple Town, Thiruverkadu. Our experience while carrying out the various procedures related to <span class="final_readmore_toshowhide7" style="display: none;">the purchase of my flat and handover keys was indeed excellent. We were particularly touched by the warm services and support by the customer care team. Now we are looking forward to similar standards regarding the interior work from the VGN Interiors department."</span>
                                  <a href="javascript:" id="readmoreid7" class="readmoreclass7" onclick="readmore(this,7)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. Thomas (Proud Customer of VGN Temple Town,Thiruverkadu)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/testimonial1.jpg" alt="Mr. Gajaraj">
                              <div class="testimonial_content">
                                <p class="saying-about" style="text-align: justify;">"Professional and Dedicated to Building a Quality Home. Thanks to VGN Team for doing the best work."</p>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. Gajaraj (Proud Customer of VGN Fairmont, Guindy)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/10_Pic.jpg" alt="Mr. G. Balakrishna">
                              <div class="testimonial_content">
                                <p class="saying-about" style="text-align: justify;">"I would like to thank entire VGN STAFFORD support team,and I request u all to keep same support to us in upcoming stages."</p>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Mr. G. Balakrishna (Proud Customer of VGN Stafford, Ambattur)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                      <div class="col-sm-6 single-card-box wow fadeInUpSmall" data-wow-duration=".7s">
                        <div class="card">
                          <div class="card-image waves-effect waves-block waves-light">
                            <div class="card-img-wrap">
                              <img class="activator" src="{{ config('app.AWS_URL').'/images/testimonial' }}/2_Pic.jpg" alt="Dr Lawrence Prabhakar Williams (Proud Customer of VGN Brent Park, Ambattur)">
                              <div class="testimonial_content">
                                <div class="saying-about" style="text-align: justify;">"Dear CRM Team, <div class="spacepara"></div> We thank you sincerely for your excellent facilitation and systematic support for the purchase of the property <span class="final_readmore_toshowhide2" style="display: none;">as well as its process till completion of sale deed registration in VGN Brent Park, Ambattur. <div class="spacepara"></div>Yourself and your sales Team were very helpful and very prompt to my queries and supported me at every stage of my Pre sales and Post sales process support for the process. <div class="spacepara"></div>I place on record appreciation for you." </span>
                                  <a href="javascript:" id="readmoreid2" class="readmoreclass2" onclick="readmore(this,2)">Read More...</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card-content">
                            <span class="card-title activator brand-text">Dr Lawrence Prabhakar Williams (Proud Customer of VGN Brent Park, Ambattur)</span>
                          </div>
                        </div>
                      </div>
                      <!-- ./single testimonial box -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Contact Section end -->
<section id="contact" class="scroll-section root-sec brand-bg contact-wrap" style="padding:40px 0px;">
  <div class="fab-container hide-on-small-only">
    <div class="top fab btn-floating btn-large red">
      <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="contact-inner">
        <div class="col-sm-12 card-box-wrap">
          <div class="row">
            <div class="clearfix section-head contact-text">
              <div class="col-sm-12">
                <h2 class="title">Contact</h2>
                <p class="regular-text">Y-222, VGN Kimberly Towers, 2nd Avenue, Y block, Anna Nagar, Chennai - 600040.</p>
                <ul class="clearfix contact-info">
                  <li>
                    <a href="tel:04443439900">Phone - 044 43439900</a>
                  </li>
                  <li>
                    <a href="tel:04443439999" id="calllink">For Sales Enquiry - 044 43439999</a>
                </ul>
                <a href="https://goo.gl/maps/sNyL8CLmpRbrFoWi7" class="btn btn-danger white" style="color: red;">
                  <i class="fa fa-map-marker"></i> View Map </a>
              </div>
              <div class="row" id="mobile_display_socialicons">
                <div class="wrapper">
                  <ul class="social-icons icon-circle icon-rotate list-unstyled list-inline hide-on-large-only">
                    <li>
                      <a href="https://www.facebook.com/VGNProjectsEstates">
                        <i class="fa fa-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://twitter.com/VGNProjects">
                        <i class="fa fa-twitter"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.youtube.com/user/vgndevelopers">
                        <i class="fa fa-youtube"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.instagram.com/vgn_projects_estates">
                        <i class="fa fa-instagram"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.pinterest.ru/vgnprojectsestatespvtltd/">
                        <i class="fa fa-pinterest"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.linkedin.com/company/27106479">
                        <i class="fa fa-linkedin"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- contact text end -->
            <div class="clearfix contact-form"></div>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
  <!-- ./container end -->
</section>
<div id="popup" class="popup panel panel-primary">
  <a id="close" class="btn btn-sm btn-danger pull-right" style="background-color: red;top: -12px; position: fixed; right: -10px;">X</a>
  <!--#fff5e9;-->
  <div class="imgpop" style="cursor: auto;">
    <a class="notting_hill" href="/project/notting_hill"></a>
    <a class="fairmont" href="/project/fairmont"></a>
    <a class="stafford" href="/project/stafford_commercial"></a>
    <a class="temple_town" href="/project/temple_town"></a>
    <a class="coasta" href="/project/coasta"></a>
    <img id="popupimage" src="{{config('app.AWS_URL')}}/images/vgn_popup_23052022.jpg" alt="popup">
  </div>
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
<img height="1" width="1" style="border-style:none;" alt="googlead" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/864630853/?guid=ON&amp;script=0"/>
</div>
</noscript>
@endsection

@section('scripts')
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
  
    <!-- <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script> -->
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min_new.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize_new/js/newmaterialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/common_home.js"></script>
    <!-- <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script> -->
  <script type="text/javascript" src="{{ config('app.AWS_URL')}}/assets/libs/slick-1.8.1/slick/slick.min.js"></script>
  
    
<script>


function readmore(e, idnum) {
  var classname = e.className;
  //alert(classname);
  if (classname == 'readmoreclass'+idnum) {
  $(".final_readmore_toshowhide"+idnum).show();
  
  $("#readmoreid"+idnum).removeClass('readmoreclass'+idnum);
  $("#readmoreid"+idnum).addClass('readlessclass'+idnum);
  $("#readmoreid"+idnum).text('Read Less...');
    
  }

  if (classname == 'readlessclass'+idnum) {
  $(".final_readmore_toshowhide"+idnum).hide();
  $("#readmoreid"+idnum).removeClass('readlessclass'+idnum);
  $("#readmoreid"+idnum).addClass('readmoreclass'+idnum);
  $("#readmoreid"+idnum).text('Read More...');
  }

  
}

//   function altersize() {
//     var wheight = $(window).height();
//     var newheight = wheight - 97;



//      if ($(document).width() < 768) {
// $("#slidetag1").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/fairmont_mobileslider_20210703.jpg');
// setTimeout(function(){
// $("#slidetag2").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/nottinghill_mobileslider_20210731.jpg');
// $("#slidetag20").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/varnabhoomiph2_mobileslider_20210424.jpg');
// $("#slidetag21").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/coasta_mobileslider_23032022.jpg');
// $("#slidetag4").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/mayfield_park_mobileslider_20210330.jpg');
// $("#slidetag5").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/TT_mobileslider_23032022.jpg');
// // $("#slidetag55").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/sparkle_mobileslider_20210802.jpg');
// // $("#slidetag56").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mobile/southern_fortune_mobileslider_20210802.jpg');
// },2000);
// //newheight = newheight - 50;
// newheight = newheight - 124;
//  $(".slides").css('cssText', 'height: '+newheight+'px;');
// $(".slider").css('cssText', 'height: '+newheight+'px; width: 100%;');

// }
// else if(($(document).width() >= 768) && ($(document).width() <= 1000)){

//     //newheight = newheight - 40;
//     newheight = newheight - 300;
//     $("#slidetag1").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/fairmont_mainslider_20210703.jpg');
// setTimeout(function(){
// $("#slidetag2").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/nottinghill_mainslider_20210731.jpg');
// $("#slidetag20").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/varnabhoomiph2_slider_20210424.jpg');
// $("#slidetag21").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-Coasta_23032022.jpg');
// $("#slidetag4").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mayfield_park_slider_20210330.jpg');
// $("#slidetag5").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-TT_23032022.jpg');
// // $("#slidetag55").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/sparkle_slider_20210802.jpg');
// // $("#slidetag56").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/southern_fortune_slider_20210802.jpg');
// },2000);
//   $(".slides").css('cssText', 'height: '+newheight+'px;');
// $(".slider").css('cssText', 'height: '+newheight+'px; width: 100%;');
// $(".home-inner").css('cssText', 'min-height: 120px; height: 120px;padding-top: 10px;');


// }
// else if(($(document).width() > 1000) && ($(document).width() <= 1367)){

//     newheight = newheight + 50;
//      $("#slidetag1").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/fairmont_mainslider_20210703.jpg');
// setTimeout(function(){
// $("#slidetag2").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/nottinghill_mainslider_20210731.jpg');
// $("#slidetag20").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/varnabhoomiph2_slider_20210424.jpg');
// $("#slidetag21").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-Coasta_23032022.jpg');
// $("#slidetag4").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mayfield_park_slider_20210330.jpg');
// $("#slidetag5").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-TT_23032022.jpg');
// // $("#slidetag55").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/sparkle_slider_20210802.jpg');
// // $("#slidetag56").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/southern_fortune_slider_20210802.jpg');
// },2000);
//   $(".slides").css('cssText', 'height: '+newheight+'px;');
// $(".slider").css('cssText', 'height: '+newheight+'px; width: 100%;');

// }
// else{
//         $("#slidetag1").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/fairmont_mainslider_20210703.jpg');
// setTimeout(function(){
// $("#slidetag2").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/nottinghill_mainslider_20210731.jpg');
// $("#slidetag20").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/varnabhoomiph2_slider_20210424.jpg');
// $("#slidetag21").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-Coasta_23032022.jpg');
// $("#slidetag4").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/mayfield_park_slider_20210330.jpg');
// $("#slidetag5").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/VGN-TT_23032022.jpg');
// // $("#slidetag55").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/sparkle_slider_20210802.jpg');
// // $("#slidetag56").attr('src','{{config("app.AWS_URL")}}/images/slider17052019/southern_fortune_slider_20210802.jpg');
// },2000);
// newheight = newheight + 50;
//   $(".slides").css('cssText', 'height: '+newheight+'px;');
// $(".slider").css('cssText', 'height: '+newheight+'px; width: 100%;');

// }

//  $('.preloader').fadeOut('slow');
//   }
  
  

 $(document).ready(function() {

  // setTimeout(function () {
  //   $("#chtbtn").trigger("click");
  // },4000);


  $(".owl-carousel").owlCarousel({
    items: 1,
    loop: true,
    nav: false,
    margin: 0,
    dots: true,
    dotsEach:true,
    dotsData:false,
    autoplay: true,
    // smartSpeed: 1000,      
    // autoplayTimeout: 7000
  });

  // experienceSlider_1
  $('.experienceSlider_1').slick({
  autoplay: true,
  autoplaySpeed: 3000,
  centerMode: true,
  centerPadding: '28px',
  slidesToShow: 3,
  arrows: false,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '30px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '10px',
        slidesToShow: 1
      }
    }
  ]
});

$('.go-left').click(function(){
  $('.experienceSlider_1').slick('slickPrev');
})

$('.go-right').click(function(){
  $('.experienceSlider_1').slick('slickNext');
})

  $('#popupimage').attr("src", "{{config('app.AWS_URL')}}/images/vgn_popup_23052022.jpg");

$('.centerscrollslider').slick({
  centerMode: true,
  centerPadding: '40px',
  slidesToShow: 2,
  arrows: false,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '30px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '10px',
        slidesToShow: 1
      }
    }
  ]
});

$('.testimslider_left').click(function(){
  $('.centerscrollslider').slick('slickPrev');
})

$('.testimslider_right').click(function(){
  $('.centerscrollslider').slick('slickNext');
})

  $("#popup").hide().fadeIn(1000);
  

    //close the POPUP if the button with id="close" is clickedd
    $("#close").on("click", function (e) {
        e.preventDefault();
        $("#popup").fadeOut(1000);
    });

  $("#projecttype").val('');
$("#location").val('');
$("#budget").val('');

  // $('.slider').slider({
  //   fullScreen: true,
  //   indicators: false,
  //   duration: 200
  // });

  // var owl = $("#owl-demo");
  $("#projecttype").on("change", function(){
  var projecttype = $("#projecttype").val();
  var sitepasseddata = @json($forjs);
  var defaultlocation = @json($list);
  console.log(defaultlocation);
  if (projecttype != '') {
    var opt = '<option value=""  selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i></option>';
      $.each(sitepasseddata, function(k,v){

        if (k.toUpperCase() == projecttype.toUpperCase()) {
        
          $.each(sitepasseddata[k], function(k1,v1){
          opt += '<option value="'+v1+'">'+v1+'</option>' ; 
          }); 
        }
        
      });
      $('#location').empty();
  $('#location').append(opt);
  $("#location").formSelect();
      console.log(opt);
  }
  else{
    var opt = '<option value=""  selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i></option>';
      $.each(defaultlocation.Location, function(k,v){  
          opt += '<option value="'+v+'">'+v+'</option>' ; 
      });
    $('#location').empty();
  $('#location').append(opt);
  $("#location").formSelect();
  }
  //console.log(projecttype);
  //console.log(sitepasseddata);
});




});


// $(window).bind("load", function() {

// $('#firstli li:not(:first-child)').remove();
// $( `<li><a href="/project/notting_hill"><img src="#" id="slidetag2" alt="VGN Notting Hill"></a></li>
// <li><a href="/project/varnabhoomi_phase_ii"><img src="#" id="slidetag20" alt="VGN Varnabhoomi Phase II"></a></li>
// <li><a href="/project/coasta"><img src="#" id="slidetag21" alt="coasta"></a></li>
// 	<li><a  href="/project/temple_town"><img src="#" id="slidetag5" alt="Temple Town"></a></li>
//        <li><a href="/project/mayfield_park"><img src="#" id="slidetag4" alt="VGN Mayfield Park"></a></li>` ).insertAfter( "#firstli" );

    

// $('.slider').slider({
//     fullScreen: true,
//     indicators: false,
//     duration: 200
//   });
// altersize();
// $('#popupimage').attr("src", "{{config('app.AWS_URL')}}/images/vgn_popup_23052022.jpg");
// //$('.modal').modal();


// });


</script>
<script>
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $("#mobile_display_socialicons").show();
  // $("body").on('click', function(){
  //   $("#dropdown1").hide();
  //   $("#dropdown2").hide();
  // $("#dropdown3").hide();
  // }); 
}else{
  $("#mobile_display_socialicons").hide();
}
</script>

@endsection
