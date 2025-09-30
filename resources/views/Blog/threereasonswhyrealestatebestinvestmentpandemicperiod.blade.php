@extends('layout.app')

@section('title')
3 reasons why real estate is the best investment in this pandemic period
@endsection

@section('description')
    <META NAME="Subject" CONTENT="3 reasons why real estate is the best investment in this pandemic period">
<meta name="description" content="3 reasons why real estate is the best investment in this pandemic period">
<meta name="keywords" content="3 reasons why real estate is the best investment in this pandemic period">
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
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/2mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/2main.jpg">

          <img src="/blogimg/2main.jpg" alt="three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period" title="three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period">
        </picture>

<div class="row person-about" style="margin-top: 15px;">
  
  
  <div class="col-md-12">
    <span class="grey-text pull-right" style="font-size: 14px;">October 13, 2020</span>
    <br>
  <p style="font-size: 17px;font-weight: 400;">In the current pandemic situation, with most investment sectors having taken a tragic hit, it is an inevitable fact that real estate has emerged as the most secure investment option. Here are some of the prominent reasons as to why real estate is the most profitable investment in this uncertain post COVID phase:</p>
<ol style="font-size: 17px;font-weight: 400; color: #000;">
 <li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Disparities in major investment sectors:</b> After COVID19, the economy slowed down and most forms of investments have taken a back seat. The stock markets in India have recorded the worst losses in history with benchmarks Sensex and Nifty languishing at multi-year lows after falling 35 percent from their January peaks, marking a severe hit with an estimated recovery period of at least 12 months. With the lockdown adding to supply chain disruptions, daily gold trading volumes on India’s MCX fell to a three-month low during the end of March. With continued import restrictions, gold rates are unstable and may not sustain anytime soon. RBI has slashed the repo rate by 75 basis points to 4.40% which has direct implications on deposit rates and banks have hinted at reducing interest rates to 3-4% on Fixed Deposits. (Source-investindia.gov.in)</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">Stability in the real estate sector:</b> The prime factor that contributed to the security of investment in the real estate sector is its offering of the highest stability as it is well insulated from the volatility of the global market. Unlike other sectors which will take a long time to recover, it has been proved time and again that real estate is one such sector that can withstand any kind of catastrophic impact and still sustain its growth. People are also realizing the importance of acquiring a residence as an asset class in their investment box, for better reliability as it offers steady returns compared to fixed deposits, bonds, shares, debentures, and gold.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> <b style="font-weight: bold;">The upsurge in home investment needs:</b> The gradual uptrend in real estate prices signifies the increasing demand even in these trying times. The comparatively weaker rupee results and increasing return of NRIs to their natives planning to settle down in their homelands have greatly contributed to this. Not to mention the limited wedding proceeding costs and overnight transformation to work from home culture that has greatly facilitated the alignment in securing a home for oneself. With all these changes in mindset and trends, it isn’t surprising that the recent survey has proved that 57% of women prefer real estate as their prime investment destination.</li>

<li style="line-height: 28px;margin-bottom: 20px;text-align: justify;"><i class="fa fa-hand-o-right"></i> Looking at the Indian market conditions, in comparison to Mumbai and Bengaluru, Chennai is still touted to be one of the progressive real estate markets with estimable locations like Guindy, Nungambakkam, ECR, Tambaram, Ambattur, Avadi, and Thiruverkadu to name a few. Having said that now is undoubtedly the right time to invest in an indulgent and convenient property like VGN Fairmont at Guindy, located just beside the Kathipara flyover, which is aptly termed as the entry point from all parts of the city!</li>

</ol>


  

  </div>
</div>


</div>

<div class="col-md-3">
                <div class="card s12">
                   <div class="card-content" style="text-align: center; margin-bottom: 15px;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;line-height: 28px;">For more information Kindly Fill in</span>
            <form class="col s12" action="/blog/three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period" method="post" style="color:#000;">
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
