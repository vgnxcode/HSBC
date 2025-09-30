@extends('layout.app')

@section('title')
VGN:Best apartment builders in Chennai| Plots promoters in Chennai
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Best apartment builders in chennai">
<meta name="description" content="VGN is the best builders and promoters in chennai mainly engaged in promoting flats,apartments with well ventilated infrastructure.">
<meta name="keywords" content="New flats in chennai, Flats for sale near thiruverkadu, Ready to occupy flats in ambattur, Best apartment builders in chennai, Plots promoters in chennai ">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Best apartment builders in Chennai| Plots promoters in Chennai'/>
<meta property='og:description' content='VGN is the best builders and promoters in chennai mainly engaged in promoting flats,apartments with well ventilated infrastructure.'/>
<meta property='og:url' content='http://vgn.in/search'/>
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
    

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    #searchdisplay div.card-img-wrap {
      min-height: 356px;
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

.select-wrapper span.select-dropdown {
    color: #fff;
    border-bottom: 1.5px solid #fff;
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
<section id="bannersearch" class="root-sec brand-bg padd-tb-120 single-banner blogpage-banner-wrap" style="margin-bottom: 0px;">
      <div class="container">
        <div class="row">
          <div class="clearfix blog-banner-text blog-single-banner">
            <div class="col-md-12">
              <h2 class="title">Project Search Page</h2>
              
                
            </div>
          </div>
        </div>

         <div class="row">
                    <form class="col s12" action="{{ url('/search') }}" method="post">
                    @csrf
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
                        @if(count($list) > 0)
                          @foreach($list['Location'] as $loc)
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

                     
                    
                    
                    </div>

                     <div class="row">
                      <div class="col s2 m2 pull-right">
                        <br>
                    <button type="submit" class="btn-floating waves-effect waves-light btn-large red white-text" ><i class="mdi-action-search"></i></button>
                    </div>
                    </div>
                    </form>
                    </div>
      </div>
    </section> 


<section class="root-sec enquireform ">
<div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li>Search</li>
</ul>
</div>
        </div>
</section>


    <section id="searchresults" class="root-sec" style="background-color: #EF533B; padding: 10px;">
        <div class="container center-align"><h2>
  <a href="#" class="btn newwhitewave waves-effect waves-light btn-medium regular-text"><i class="mdi-action-info-outline left"></i> {{ count($searchlist) }} results found</a></h2>
  </div>
</section>

    <!-- Blog Section end -->
    <section id="searchdisplay" class="scroll-section root-sec grey lighten-5 padd-tb-60 blog-wrap">
      <div class="container">
        <div class="row">
          <div class="blog-inner">
            <div class="col-sm-12 card-box-wrap">
              <div class="row">
        
                <div class="clearfix card-element-wrapper" id="blog-posts">
                    @if(count($searchlist) > 0)
                    @foreach($searchlist as $search)
                    <?php $projectname_str = strtolower(str_replace(' ', '_', $search->Project_name)); ?>
                  <article class="col-sm-6 col-md-4 single-card-box single-post">
                    <div class="card" >
                      <div class="card-image">
                        <div class="card-img-wrap">
                          <div class="blog-post-thumb waves-effect waves-block waves-light">
                          @if($search->no_details != null)
                          <a href="#">
                          @else
                          <a href="{{ url('/project')}}/{{ $projectname_str }}">
                          @endif
                            
                      
			@if(count(Storage::disk('s3')->files('/images/project_thumb/' . $search->id)) > 0)
                                <?php $planfiles = Storage::disk('s3')->files('/images/project_thumb/' . $search->id); ?>
                        <img class="activator img-responsive" src="{{ config('app.AWS_URL')}}/{{$planfiles[0]}}" alt="{{$search->Project_name}}">      
                      @else
                          @if($search->Type == 'Apartments')
                          <img class="activator img-responsive" src="{{ config('app.AWS_URL')}}/images/project_thumb/default_flats.jpg" alt="{{$search->Project_name}}">
                          @elseif($search->Type == 'Plots')
                          <img class="activator img-responsive" src="{{ config('app.AWS_URL')}}/images/project_thumb/default_plots.jpg" alt="{{$search->Project_name}}">
                          @else
                          @endif
                      @endif

                            </a>
                          </div>
                          <div class="post-body">
                          @if($search->no_details != null)
                          <a href="#" class="post-title-link brand-text">
                          @else
                          <a href="{{ url('/project')}}/{{ $projectname_str }}" class="post-title-link brand-text">
                          @endif
                            
                            <h2 class="post-title">VGN {{ $search->Project_name }}</h2></a>
                            @if($search->Location != null)
                            <p class="post-content">Location: {{ $search->Location }}</p>
                            @else
                            <p class="post-content"></p>
                            @endif
                            @if($search->Type != null)
                            <p class="post-content">Project Type: {{ $search->Type }}</p>
                            @else
                            <p class="post-content"></p>
                            @endif
                            @if($search->Status != null)
                            <p class="post-content">Status: {{ $search->Status }}</p>
                            @else
                            <p class="post-content"></p>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="clearfix card-content">
                      @if($search->no_details != null)
                      <a href="#" class="brand-text right waves-effect">
                      @else
                      <a href="{{ url('/project')}}/{{ $projectname_str }}" class="brand-text right waves-effect">
                      @endif
                        
                        More Details</a>
                      </div>
                    </div>
                  </article> <!-- ./single blog post end -->
                  @endforeach
                  
                  @endif
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
    <!-- #blog Section end -->

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
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
  
    
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
			
    <script>
      $(document).ready(function(){
$("#projecttype").val('');
$("#location").val('');
$("#budget").val('');

@if(session()->has('scroll'))
var searchresultsoffset = $("#searchresults").offset();
$("html, body").animate({ scrollTop: searchresultsoffset.top-80 }, 800);
@endif

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
