@extends('layout.app')

@section('title')
VGN:Flat builders in Chennai| Best apartment builders in Chennai
@endsection

@section('description')
   <META NAME="Subject" CONTENT="Flat builders in Chennai">
<meta name="description" content="VGN is the best trusted flat and apartment builders in chennai offers exclusive homes with magnificient styles with best deals. ">
<meta name="keywords" content="Apartments for sale in nungambakkam, New flats in chennai, New flats in thiruverkadu, Flat builders in chennai, Best apartment builders in chennai">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Flat builders in chennai| Best apartment builders in chennai'/>
<meta property='og:description' content='VGN is the best trusted flat and apartment builders in chennai offers exclusive homes with magnificient styles with best deals.'/>
<meta property='og:url' content='http://vgn.in/Flat-Builders-Chennai'/>
<meta property='og:site_name' content='VGN Projects Estates Pvt Ltd'/>
<meta property='og:type' content='article'/>
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

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/blog.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    #portfolio div.card-img-wrap {
      min-height: 356px;
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
.titlenew {
    font-size: 26px !important;
}
select.browser-default{
  margin: 5px auto;
  color: #F44336;
  border: 1px solid #a2a2a2;
  box-shadow: 2px 2px 4px #a2a2a2;
}


    </style>

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
              <h2 class="title">Completed Projects</h2>
              <!-- <p class="regular-text">This webpage contains the apartments and plots of completed projects</p> -->
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
  <li>Completed Projects</li>
</ul>
</div>
        </div>
          <div class="container">
            
            <div class="row">
                      
                      <div class="col s10 m4">
                        <select class="browser-default" name="projecttype" id="projecttype">
                        <option value="" selected>Project Type <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        <option value="apartments">Apartments</option>
                        <option value="plots">Plots</option>
                        </select>
                    </div>
                    <div class="col s10 m4">
                        <select class="browser-default" name="location" id="location">
                        <option value="" selected>Location <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        @if(count($locationlist) > 0)
                          @foreach($locationlist['Location'] as $loc)
                          <option value="{{$loc}}">{{$loc}}</option>
                          @endforeach
                        @endif
                        </select>
                    </div>
                     <div class="col s10 m4">
                        <select class="browser-default" name="budget" id="budget">
                        <option value=""  selected>Budget <i class="fa fa-caret-up fa-fw pull-right"></i></option>
                        <option value="10L-20L">10 - 20 Lakhs</option>
                        <option value="21L-40L">21 - 40 Lakhs</option>
                        <option value="41L-60L">41 - 60 Lakhs</option>
                        <option value="61L-80L">61 - 80 Lakhs</option>
                        <option value="81L-99L">81 - 99 Lakhs</option>
                        <option value="1C">1 Crore Plus</option>
                        </select>
                    </div>
                                      

                     

                     

                    
                    <div class="fixed-action-btn pull-right">
                      <br>
                      <a type="button" class="btn btn-small waves-effect waves-light red" id="searchbtn">Submit</a>
              <a class="btn btn-small waves-effect waves-light red" href="{{url('/Flat-Builders-Chennai')}}">Reset</a>
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
       <div class="fab-container hide-on-small-only">
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
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
  
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>

    <script>
     
    $(document).ready(function(){
        $("#loader").show();
        $("#projecttype").val('');
$("#location").val('');
$("#budget").val('');
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$('.title').addClass('titlenew');
		}else{
			$('.title').removeClass('titlenew');
		}
         var mainlocation = $("#location").val();
         var mainbudget = $("#budget").val();
           var mainptype = $("#projecttype").val();
           
        if((mainlocation == '')&&(mainbudget == '')&&(mainptype == '')){
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
           
            
            $.post('/Flat-Builders-Chennai', {_token:"{{csrf_token()}}",location: location,budget:budget,ptype:ptype}, function(result){
                
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
  var projecttype = $("#projecttype").val();
  var sitepasseddata = @json($forjs);
  var defaultlocation = @json($locationlist);
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
    </script>
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
