@extends('layout.app')

@section('title')
VGN: Sponsorships
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Sponsorships">
<meta name="description" content="Sponsorships">
<meta name="keywords" content="Sponsorships">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='VGN Sponsorships'/>
<meta property='og:description' content='Sponsorships'/>
<meta property='og:url' content='http://vgn.in/sponsorships'/>
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
    color: #727272;
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
      color: #727272;
      text-transform: uppercase;
}

.key .coreteam-inner .card-header {
  min-height: 240px;
    max-height: 240p
}

.key .coreteam-inner .card {
  width: 250px;
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
  <li>About Us</li>
  <li>Sponsorships</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-8">
              <div class="person-about">
                <h3 class="about-subtitle">Sponsorships</h3>
                <p>VGN was the principal sponsor of Chennai Super Kings (CSK) in the Indian Premier League Cricket 2012 – 2013. VGN has also sponsored various social events including Rotary International, Round Table Conference, Vintage Car Rally and other sports, cultural and charitable events.</p>
                
              </div>

             </div>
            <!-- about me description -->

            <!-- about me image -->

            <div class="col-sm-6 col-md-4">
                          
            </div>
            <!-- about me info -->

          </div>
        </div>
      </div>
      <!-- .container end -->
      
    </section>
    <!-- #about Section end -->

    
    
 
 <!-- Funfacts Section end -->
        
<!--Section: Team v.1-->

    <!-- Funfacts Section end -->
    
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
