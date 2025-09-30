@extends('layout.app')

@section('title')
The Remarkable Transformation Of Ambattur
@endsection

@section('description')
    <META NAME="Subject" CONTENT="The Remarkable Transformation Of Ambattur">
<meta name="description" content="The Remarkable Transformation Of Ambattur">
<meta name="keywords" content="The Remarkable Transformation Of Ambattur">
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
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/5mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/5main.jpg">

          <img src="/blogimg/5main.jpg" alt="The_Remarkable_Transformation_Of_Ambattur" title="The_Remarkable_Transformation_Of_Ambattur">
        </picture>

<div class="row person-about" style="margin-top: 15px;">
  
  
  <div class="col-md-12">
    <span class="grey-text pull-right" style="font-size: 14px;">October 28, 2020</span>
    <br>
  <p style="font-size: 17px;font-weight: 400;">Ambattur, located in the western part of Chennai, has tremendously grown from being an extensive agricultural village to gradually upgrading into an IT, Industrial, and Technology hub of the city. This has commendably increased the investment value of the place by many folds. Following are some of the noteworthy developments in the region</p>
<ol style="font-size: 17px;font-weight: 400; color: #000;">
 <li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Commercial advancement:</b> In the whole of South Asia, the Ambattur industrial estate is the largest small scale industrial estate. Not to mention that this has enhanced the commercial value of the area by leaps and bounds over time, attracting so many infrastructure development projects, manufacturing plants of TI cycles, Britannia, TVS, and renowned IT companies namely HCL, DEL, and TCS to name a few.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Real estate progress:</b> There has been a constant progressive inflow of numerous residential projects in Ambattur, ranging from affordable to lavish apartments and many notable extravagant independent housing projects. There has been a steady appreciation in the real estate segment in Ambattur in the past few years, which has attracted even more housing projects to the region promising plenty of scope for the incremental value of the area. This has contributed to Ambattur becoming one of the leading hotspots in Chennai for residential investments.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Uninterrupted connectivity:</b> One of the main railway lines of Chennai passes right through the midline of Ambattur dividing it into two halves and has two prominent stations in the neighbourhood. The Chennai-Tiruvallur high road, Chennai bypass road, and the Chennai-Kolkata highway make Ambattur a strategically sound location which could have also been one of the obvious reasons for such successful industrial establishments functioning in the area. With numerous bus stops and the CMBT bus terminus located nearby, bus transportation to the area has no hindrance. Not to mention, it is surrounded by buzz areas like Avadi, Padi, Mogappair, and Anna Nagar.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Health Care and Education Options:</b> Having become a developed area over time with increasing population demands, a lot of essential and luxury amenities have crowded in Ambattur. Sir Iven Stedeford Hospital is one of the famous healthcare facilities in the area addressing at least 1000 outpatients every day in and around the region. There are many more multispecialty hospitals including Apollo and Mayaa among, the most famous ones providing superior services. There are many renowned schools in the area that parents aspire to get their kids into SBOA and DAV are two of such celebrated ones.</li>


</ol>

<p style="font-size: 17px;font-weight: 400;">If you are looking to invest in a property in such a fast-paced developing area like Ambattur with exponential appreciation in the recent years, then <a href="/project/stafford">VGN Stafford</a> will be a steal deal for you, with all the required amenities, and the surge in retail, entertainment and IT parks in the vicinity!</p>


  <ol>
    <li></li>
  </ol>

  </div>
</div>


</div>

<div class="col-md-3">
                <div class="card s12">
                   <div class="card-content" style="text-align: center; margin-bottom: 15px;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;line-height: 28px;">For more information Kindly Fill in</span>
            <form class="col s12" action="/blog/The_Remarkable_Transformation_Of_Ambattur" method="post" style="color:#000;">
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
