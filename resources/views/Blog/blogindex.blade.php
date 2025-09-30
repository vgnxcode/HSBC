@extends('layout.app')

@section('title')
VGN Blog Page
@endsection

@section('description')
<META NAME="Subject" CONTENT="VGN Blog Page">
<meta name="description" content="VGN Blog Page">
<meta name="keywords" content="VGN Blog Page">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Premium builders in chennai| Premium real estate developers in chennai'/>
<meta property='og:description' content='We are the most Reputed Premium real estate builders and developers in chennai offers high quality flats and apartments with good infrastructure.'/>
<meta property='og:url' content='http://vgn.in/Premium-Builders-in-Chennai '/>
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
    #about li.collection-item p {
      line-height: 24px;
    font-size: 14px;
    color: #727272;
    }
    #about li.collection-item h6 {
      font-size: 13px;
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


    </style>
     
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist">
      <div class="container">

        <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li>Blog</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            
           <div class="col-md-10 col-md-offset-1">
             <h2 class="about-subtitle">Latest Blog Updates</h2>

 <!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/live_in_your_perfect_luxury_dream_house_in_a_perfect_location_in_chennai">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/7mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/7main.jpg">
          <img src="/blogimg/7main.jpeg" alt="live_in_your_perfect_luxury_dream_house_in_a_perfect_location_in_chennai" title="live_in_your_perfect_luxury_dream_house_in_a_perfect_location_in_chennai">
        </picture>
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">January 07, 2021</span>
              <br>
              <p style="text-align: justify;">Everyone wants to live in a perfect luxurious home at the most convenient location in a city like Chennai. The feel of living in a luxurious home is truly blissful! That's why the demand [...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->

<!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/five_reasons_why_Guindy_should_be_your_next_choice_to_buy_apremium_apartment">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/6mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/6main.jpg">
          <img src="/blogimg/6main.jpeg" alt="five_reasons_why_Guindy_should_be_your_next_choice_to_buy_apremium_apartment" title="five_reasons_why_Guindy_should_be_your_next_choice_to_buy_apremium_apartment">
        </picture>
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">January 04, 2021</span>
              <br>
              <p style="text-align: justify;">Guindy is undoubtedly the heart of Chennai city! Over the years Guindy has become the most preferred residential location in Chennai . Guindy enjoys a well-planned residential housing layout system along with good wide [...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->

<!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/The_Remarkable_Transformation_Of_Ambattur">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/5mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/5main.jpg">
          <img src="/blogimg/5main.jpeg" alt="The_Remarkable_Transformation_Of_Ambattur" title="The_Remarkable_Transformation_Of_Ambattur">
        </picture>  
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">October 28, 2020</span>
              <br>
              <p style="text-align: justify;">Ambattur, located in the western part of Chennai, has tremendously grown from being an extensive agricultural village to gradually upgrading into an IT, Industrial, and Technology hub of [...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->
<!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/importance_of_vastu_for_a_holistic_lifestyle">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/4mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/4main.jpg">
          <img src="/blogimg/4main.jpeg" alt="importance_of_vastu_for_a_holistic_lifestyle" title="importance_of_vastu_for_a_holistic_lifestyle">
        </picture>
              
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">October 24, 2020</span>
              <br>
              <p style="text-align: justify;">Vastu is the architectural science that deals with the holistic designing of a home to facilitate the abundant flow of positive energy in the household. There is a predominant notion that Vastu is[...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->


<!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/live_the_beach_life_in_chennai">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/3mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/3main.jpg">
          <img src="/blogimg/3main.jpeg" alt="live_the_beach_life_in_chennai" title="live_the_beach_life_in_chennai">
        </picture>

            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">October 17, 2020</span>
              <br>
              <p style="text-align: justify;">There is no man in this world who wouldn’t love to spend time at the beach with the soul-filling seawater drenching the legs and the harmony of the sea breeze tending one with peace. If that same beach is in the proximity of your own home, then it is no less than a dream comes true for[...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->

              <!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/2mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/2main.jpg">
          <img src="/blogimg/2main.jpeg" alt="three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period" title="three_reasons_why_real_estate_is_the_best_investment_in_this_pandemic_period">
        </picture>
              
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">October 13, 2020</span>
              <br>
              <p style="text-align: justify;">In the current pandemic situation, with most investment sectors having taken a tragic hit, it is an inevitable fact that real estate has emerged as the most secure investment option. Here are some of the prominent reasons as to why real estate is the most profitable investment in this uncertain[...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->


             <!--start-->
             <div class="row">
        <div class="col-md-12" style="margin-bottom: 30px;">
          <a href="/blog/five_facts_why_nungambakkam_is_the_best_location_to_lives">
          <div class="card">
            <div class="card-image">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/1mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/1main.jpg">
          <img src="/blogimg/1main.jpg" alt="five_facts_why_nungambakkam_is_the_best_location_to_lives" title="five_facts_why_nungambakkam_is_the_best_location_to_lives">
        </picture>
              
            </div>
            <div class="card-content">
              <!-- <h3 style="color: #000; text-transform: uppercase;">5 facts why Nungambakkam is the best location to lives</h3> -->
              <span class="grey-text pull-right" style="font-size: 14px;">October 7, 2020</span>
              <br>
              <p style="text-align: justify;">With some of the eminent landmarks of the city located in Nungambakkam, it can very well be termed as a prominent hub for all of Chennai. From shopping, dining, and sports, to green zones, arts and ongoing events, Nungambakkam has got it all covered. The following are the top five facts as to why settling down in a[...]</p>
              <br>
              <span class="pull-right" style="color: blue;">Read More >> </span>
            </div>
            </a>
          </div>

        </div>
      </div>
             <!--end-->


           </div>

          </div>
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
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
	
	
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

    $("#mobilecontact_btn").on("click", function(){
			setTimeout(function(){
				window.open('tel:04443439999');
			},3000);
	  });

});
</script>
	<script>
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

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
