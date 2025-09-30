@extends('layout.app')

@section('title')
Live in your perfect luxury dream house in a perfect location in Chennai - Luxury Apartment in Nungambakkam
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Live in your perfect luxury dream house in a perfect location in Chennai - Luxury Apartment in Nungambakkam">
<meta name="description" content="VGN Notting Hill is the leading Luxury Apartment In Nungambakkam with all the latest amenities and good proximity to the commercial areas. For more details, contact us today.">
<meta name="keywords" content="5 reasons why Guindy should be your next choice to buy a premium apartment">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

@endsection

@section('keyword')
   
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
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

        
          
        


<section style="position:relative;">
    <div class="col-md-9" align="center">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/7mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/7main.jpg">

          <img src="/blogimg/7main.jpg" alt="a_perfect_location_to_buy_your_luxury_dream_home" title="a_perfect_location_to_buy_your_luxury_dream_home">
        </picture>

<div class="row person-about" style="margin-top: 15px;">
  
  
  <div class="col-md-12">
    <span class="grey-text pull-right" style="font-size: 14px;">January07, 2021</span>
    <br>
  <p style="font-size: 17px;font-weight: 400;">Everyone wants to live in a perfect luxurious home at the most convenient location in a city like Chennai. The feel of living in a luxurious home is truly blissful! That's why the demand for <a href="/project/notting_hill">Premium Builders In Chennai</a> never fades away. With the rising standard of living, increasing disposable income and rising aspirations, more and more people are choosing to live in a luxury apartment in Nungambakkam, Chennai.</p>
  <h1 style="line-height: 28px;color: #000; font-size: 18px;font-weight: 800;margin-bottom: 20px;text-align: justify; ">Benefits of living in a luxurious apartment in a perfect location:</h1>
<ol style="font-size: 17px;font-weight: 400; color: #000;">
 <li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Good environment</b> - a well planned luxurious apartment complex has the best environment, that is peaceful and of diverse culture. It especially provides a conducive environment for children and senior citizens.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Modern lifestyle</b> - A really attractive part of buying a luxurious apartment is the ultra-modern lifestyle of the residents living in these apartments. From Video Door Phone Systems to electronic security systems, all adding to the comfort and lifestyle that most people deeply desire for.</li>


</ol>

<h3 style="line-height: 28px;color: #000; font-size: 18px;font-weight: 800;margin-bottom: 20px;text-align: justify; ">Investment value - Real estate is one of the most traditional forms of wealth investment. The value of a good property is always on the rise.  It is a performing asset that will give you multiple returns in the future!</h3>
<h3 style="line-height: 28px;color: #000;  font-size: 18px;font-weight: 800;margin-bottom: 20px;text-align: justify;">Big space - Luxury apartments can accommodate a great number of people. This means that you don’t have to worry when your friends or guests plan to have a short stay at your place. You can live comfortably without having to worry about space issues because you are certainly never going to face them.</h3>
<br>
<p style="font-size: 17px;font-weight: 400;">The most sought after residential location in Chennai is Nungambakkam! Many people dream of having a <a href="/project/notting_hill">Luxury Apartment In Nungambakkam</a>. This locality is very well known as the commercial spot of Chennai! Right from shopping centers, educational institutes, corporates, businesses to hospitals, Nungambakkam is like a beautiful city in itself.</p>
<p style="font-size: 17px;font-weight: 400;">The luxury apartment in Nungambakkam has a timeless appeal, they are extremely beautiful and have all the modern amenities like a swimming pool, Well-equipped gym, multi-purpose hall, indoor games area, Air-Conditioned Lobbies, CCTV in common areas, and much more! Living in a luxury apartment in Nungambakkam will not only provide you with comfort and great aesthetics but will also ensure your safety and security. The top-notch security systems provided in these apartments are superior in quality and make you feel stress-free. Thus, Nungambakkam is the best area for you to <a href="/project/notting_hill">Buy an Apartment In Chennai</a>.</p>
<p style="font-size: 17px;font-weight: 400;">But in a place where the real estate market is very crowded, it's easy for one to get lost and to make the right decision to buy from the most genuine real estate developers.</p>
<p style="font-size: 17px;font-weight: 400;">So if you are eagerly looking for <a href="/project/notting_hill">Flats For Sale In Chennai</a>, then your search ends with VGN Notting Hill. Extremely well-constructed Apartments with all the amenities.</p>



  </div>
</div>


</div>

<div class="col-md-3">
                <div class="card s12">
                   <div class="card-content" style="text-align: center; margin-bottom: 15px;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;line-height: 28px;">For more information Kindly Fill in</span>
            <form class="col s12" action="/blog/live_in_your_perfect_luxury_dream_house_in_a_perfect_location_in_chennai" method="post" style="color:#000;">
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
