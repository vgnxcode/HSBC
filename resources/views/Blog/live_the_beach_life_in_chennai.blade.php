@extends('layout.app')

@section('title')
LIVE THE BEACH LIFE IN CHENNAI
@endsection

@section('description')
    <META NAME="Subject" CONTENT="LIVE THE BEACH LIFE IN CHENNAI">
<meta name="description" content="LIVE THE BEACH LIFE IN CHENNAI">
<meta name="keywords" content="LIVE THE BEACH LIFE IN CHENNAI">
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
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/mobileflag/css/jquery.ccpicker.css">
    <style>
    #about li.collection-item p {
      line-height: 24px;
    font-size: 14px;
    color: #727272;
    }
    #about li.collection-item h6 {
      font-size: 13px;
    }
.cc-picker {
      float: left;
    }

    #about ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    background-color: #eee;
    font-size: 12px;
    color: #000;
    text-transform: uppercase;
    border-radius: 5px;
}

/* Display list items side by side */
#about ul.breadcrumb li {
    display: inline;
}

/* Add a slash symbol (/) before/behind each list item */
#about ul.breadcrumb li+li:before {
    padding: 8px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
#about ul.breadcrumb li a {
    text-decoration: none;
}

/* Add a color on mouse-over */
#about ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}

.bread .about-inner {
  margin: 52px 0px 10px 0px
}

.keypeople, .coreteam-inner .keypeople p{
  text-align: center;
  text-transform: uppercase;
}
.keypeople h3 {
      color: #000;
      text-transform: uppercase;
}

.key .coreteam-inner .card-header {
  min-height: 240px;
    max-height: 240p
}

.key .coreteam-inner .card {
  width: 250px;
}
		
		.coreteam-inner .card-header{
  max-height: 300px !important;
}

.maincore {
    padding-top: 0px;
}
.cc-picker {
  top: 35px;
  }
  .cc-picker-code-select-enabled {
    padding-right: 8px !important;
  }

    </style>
     
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist">
      <div class="container-fluid">

        <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/blog') }}">Blog</a></li>
  <li>Blog Page</li>
</ul>
</div>
        </div>

        
          
        


<section style="position:relative;text-align:center;">
    <div class="col-md-9">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/3mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/3main.jpg">

          <img src="/blogimg/3main.jpg" alt="live_the_beach_life_in_chennai" title="live_the_beach_life_in_chennai">
        </picture>

<div class="row person-about" style="margin-top: 15px;">
  
  
  <div class="col-md-12">
    <span class="grey-text pull-right" style="font-size: 14px;">October 17, 2020</span>
    <br>
  <p style="font-size: 17px;font-weight: 400;">There is no man in this world who wouldn’t love to spend time at the beach with the soul-filling seawater drenching the legs and the harmony of the sea breeze tending one with peace. If that same beach is in the proximity of your own home, then it is no less than a dream comes true for many. Sea facing residences have never lost their imbibing charm since time immemorial and, the following are some treasured reasons for the same:</p>
<ol style="font-size: 17px;font-weight: 400; color: #000;">
 <li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Scenic View:</b> Waking up to the spectacular view of the morning sun rays glazing upon the beautiful blue sea and feeling the calming breeze on the face in the early hours of the day while stretching on the balcony and sipping a cup of tea is not something everyone is blessed with. Especially, not to mention the dazzling view in the night with the ravishing moon shimmering in the ocean. It instils euphonic vibrations in a person inducing the sheer joy of aligning with nature. It is the foremost reason why sea-facing apartments are precious, close to heart desire for many.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Wellbeing assurance:</b> Complete wellbeing is defined as the holistic wellness of the body and mind. This is assured when one lives close to nature, breathing fresh air that enhances the body’s wellness, with a calming scenic environment and a neighbourhood that truly nourishes the soul. Sea view apartments are located in proximity to the beach which is usually devoid of much traffic that assures the same. Research says that the sound of the waves has a calming and rejuvenating impact on the human body and mind. Also, with the population being niche here, and with all the health, fitness, and hygiene amenities facilitated within, it becomes a truly winning state beyond just luxury.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Harmonious indulgence:</b> Beach facing houses are like blissful heaven on earth and give the ultimate fantasies of an affluent lifestyle. From a psychological point of view, beachside living is more like a holiday extravagance. Irrespective of the season, seaside locations will remain optimal and enjoyable as they aren't prone to extreme conditions. The house layout, ventilation, balconies, and windows designed to appropriately magnify the pleasure of the surroundings make it pampering appeasement that can be sensed and relished throughout the day. All beach properties are mostly luxurious ones designed with five-star amenities for utmost sophistication enabling harmonious indulgence for all the senses.</li>



</ol>


  <p style="font-size: 17px;font-weight: 400;">With Chennai being located in the coastal area of Tamil Nadu, it can only be considered fortunate to live in a magnificent location like ECR. The whole of Chennai moves to ECR for weekends, so just imagine living there all days of the week? <a href="{{ url()->full() }}/project/coasta">VGN Coasta</a>, located in a prime scenic location like ECR is truly a dream residence with Vastu compliance for a happening opulent lifestyle, close to Mother Nature!</p>

  </div>
</div>


</div>

<div class="col-md-3">
                <div class="card s12">
                   <div class="card-content" style="text-align: center; margin-bottom: 15px;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;line-height: 28px;">For more information Kindly Fill in</span>
            <form class="col s12" action="/blog/live_the_beach_life_in_chennai" method="post" style="color:#000;">
                      {{ csrf_field() }}
                       @if(session()->has('error_msg'))
            <span style="color:red;">{!! Session::get('error_msg') !!}</span>
          @endif
          @if(session()->has('suc_msg'))
            <span style="color:green;">{!! Session::get('suc_msg') !!}</span>
        @endif
                    <div class="row">
                      <div class="input-field col s10 m12">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Name">Name</label>
                    </div>                     
                    </div>
        
        <div class="row">
                    <div class="input-field col s7 m9">
                       <input id="Mobile1" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}" style="height: 3rem;padding-left: 70px;">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile</label>
                    </div>

                    </div>
                    <div class="row">   
                     <div class="input-field col s10 m12">
                        <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s10 m12">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                    </div>


                
                    <div class="row">
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text" ><i class="fa fa-send"></i> Submit</button>
                    </div>
                    </div>
                    
                    </form>

            </div>
                </div>
              </div>
      </section>


       
        </div>
      </div>
      <!-- .container end -->
      
    </section>
    <!-- #about Section end -->

    
    

 

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
    
    <script src="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
    <script src="{{ config('app.AWS_URL')}}/mobileflag/js/jquery.ccpicker.js" type="text/javascript"></script>
	
	
    <script>
 $(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({
    autoPlay : 6000,
    navigation : false,
    singleItem : true,
    transitionStyle : "fade",
    responsive: true
  });

   $("#Mobile1").CcPicker();
        $("#Mobile1").CcPicker("setCountryByCode","IN");
             $('#Name, #City').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});

   $("#mobilecontact_btn").on("click", function(){
			setTimeout(function(){
				window.open('tel:04443439999');
			},3000);
	 });
 
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

    @if(session()->has('success'))
    <script>
    swal({
  title: "Success",
  text: "{{Session::get('success')}}",
  type: "success"
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
