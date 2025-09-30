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
        
        .select-wrapper span.select-dropdown {
    color: #fff;
    border-bottom: 1.5px solid #fff;
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
                      
                     <div class="col s10 m3">
                        <select name="location" id="location">
                        <option value="" selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        @if(count($locationlist) >= 1)
                        @foreach($locationlist as $location)
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

                    
                    <div class="fixed-action-btn pull-right">
                      <a type="button" class="btn btn-small waves-effect waves-light red" id="searchbtn">Submit</a>
              <a class="btn btn-small waves-effect waves-light red" href="{{url('/Premium-Real-Estate-Developers-in-Chennai')}}">Reset</a>
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
             
             <div class="container" id="loader">
             <div class="row">
                 <div class="col-sm-4 col-sm-offset-4">
                     
                 
              <div class="preloader-wrapper small active">
      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
               </div>
             </div>
                </div>
                </div>
                
              <ul class="clearfix protfolio-item" id="protfolio-msnry">
              
              
               

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
    <script>
    $(document).ready(function(){
        $("#loader").show();
 

         var mainlocation = $("#location").val();
         var mainbudget = $("#budget").val();
           var mainptype = $("#projecttype").val();
           var mainpstatus = $("#pstatus").val();
        if((mainlocation == '')&&(mainbudget == '')&&(mainptype == '')&&(mainpstatus == '')){
            var list=<?php echo json_encode($list); ?>;
        generatelist(list);
        }
        
        function generatelist(list){
            
                      if(list.length > 0)
                          var content = '';
              $.each(list, function(i,val){
                 var projectname =val.Project_name.replace(/ /g,'_');
                  projectname = projectname.toLowerCase();
                  
                  content += `<li class="col-sm-6 col-md-4 single-port-item `+val.Type+`-1">
                <article class="single-card-box single-post">
              <div class="card marginrightzero">
                <div class="card-image">
                  <div class="card-img-wrap">
                    <div class="blog-post-thumb waves-effect waves-block waves-light">`;
                  
                  if(val.no_details != null){
                      content += `<a href="#">`;
                  }
                  else{
                      content += `<a href="{{ url('/project')}}/`+projectname+`">`
                  }
                  
                  

                       content += `<img class="activator img-responsive" src="`+val.projectthumbimagelink+`" alt="`+val.Project_name+`"></a>
                    </div>`;
                  
                  
                 content += ` <div class="post-body">`;
                    if(val.no_details != null){
                    content += `<a href="#" class="post-title-link brand-text"><h2 class="post-title">VGN `+val.Project_name+`</h2></a>`;
                    }
                    else{
                    content += `<a href="{{ url('/project')}}/`+projectname+`" class="post-title-link brand-text"><h2 class="post-title">VGN `+val.Project_name+`</h2></a>`;
                    }
                    
                      
                      if(val.Location != null){
                      content += `<p class="post-content">Location: `+val.Location+`</p>`;
                      }
                      if(val.Type != null){
                      content += `<p class="post-content">Project Type: `+val.Type+`</p>`;
                      }
                    content += `</div>
                  </div>
                </div>
                <div class="clearfix card-content">`;
                  if(val.no_details != null){
                  content += `<a href="#" class="brand-text right waves-effect">MORE DETAILS</a>`;
                  }else{
                  content += `<a href="{{ url('/project')}}/`+projectname+`" class="brand-text right waves-effect">MORE DETAILS</a>`;
                  }
                content += `</div>
              </div>
            </article></li>`;
                      
                  
                      
                  
              });
            $("#loader").hide();
   
            $("#protfolio-msnry").html(content);
            
        }


        $("#searchbtn").on("click", function(){
            $("#protfolio-msnry").html('');
            $("#loader").show();
           var location = $("#location").val();
           var budget = $("#budget").val();
           var ptype = $("#projecttype").val();
           var pstatus = $("#pstatus").val();
            
            $.post('/Premium-Real-Estate-Developers-in-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype,pstatus:pstatus}, function(result){
                
                setTimeout(function(){
                    
                
                console.log(result);
                if(result.list.length == 0){
                    
                    var newcontent = `<li><h4 style="font-size: 18px;color: #000;">No results found!</h4></li>`;
                    $("#protfolio-msnry").html(newcontent);
                }
                generatelist(result.list);
                    $("ul#protfolio-msnry.clearfix.protfolio-item").css({'height': 'auto'});
                    },3000);
            });
        });
        
       /* $("#location").on("change", function(){
            $("#protfolio-msnry").html('');
            $("#loader").show();
           var location = $(this).val();
           var budget = $("#budget").val();
           var ptype = $("#projecttype").val();
           var pstatus = $("#pstatus").val();
            
            $.post('/Premium-Real-Estate-Developers-in-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype,pstatus:pstatus}, function(result){
                
                setTimeout(function(){
                    
                
                console.log(result);
                if(result.list.length == 0){
                    
                    var newcontent = `<li><h4 style="font-size: 18px;color: #000;">No results found!</h4></li>`;
                    $("#protfolio-msnry").html(newcontent);
                }
                generatelist(result.list);
                    $("ul#protfolio-msnry.clearfix.protfolio-item").css({'height': 'auto'});
                    },3000);
            });
        });
        
        $("#budget").on("change", function(){
            $("#protfolio-msnry").html('');
           $("#loader").show();
            var location = $("#location").val();
           var budget = $(this).val();
           var ptype = $("#projecttype").val();
           var pstatus = $("#pstatus").val();
            
            $.post('/Premium-Real-Estate-Developers-in-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype,pstatus:pstatus}, function(result){
                setTimeout(function(){
                console.log(result);
                if(result.list.length == 0){
                    var newcontent = `<li><h4 style="font-size: 18px;color: #000;">No results found!</h4></li>`;
                    $("#protfolio-msnry").html(newcontent);
                }
                generatelist(result.list);
                    $("ul#protfolio-msnry.clearfix.protfolio-item").css({'height': 'auto'});
                    },3000);
            });
            
        });
        
        $("#projecttype").on("change", function(){
            $("#protfolio-msnry").html('');
            $("#loader").show();
            var location = $("#location").val();
           var budget = $("#budget").val();
           var ptype = $(this).val();
           var pstatus = $("#pstatus").val();
            
            $.post('/Premium-Real-Estate-Developers-in-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype,pstatus:pstatus}, function(result){
                setTimeout(function(){
                console.log(result);
                if(result.list.length == 0){
                    var newcontent = `<li><h4 style="font-size: 18px;color: #000;">No results found!</h4></li>`;
                    $("#protfolio-msnry").html(newcontent);
                }
                generatelist(result.list);
                    $("ul#protfolio-msnry.clearfix.protfolio-item").css({'height': 'auto'});
                    },3000);
            });
        });
        
        $("#pstatus").on("change", function(){
            $("#protfolio-msnry").html('');
            $("#loader").show();
           var location = $("#location").val();
           var budget = $("#budget").val();
           var ptype = $("#ptype").val();
           var pstatus = $(this).val();
            
            $.post('/Premium-Real-Estate-Developers-in-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype,pstatus:pstatus}, function(result){
                setTimeout(function(){
                console.log(result);
                if(result.list.length == 0){
                    var newcontent = `<li><h4 style="font-size: 18px;color: #000;">No results found!</h4></li>`;
                    $("#protfolio-msnry").html(newcontent);
                }
                generatelist(result.list);
                    $("ul#protfolio-msnry.clearfix.protfolio-item").css({'height': 'auto'});
                    },3000);
            });
        });*/
        
    });
        </script>
@endsection
    