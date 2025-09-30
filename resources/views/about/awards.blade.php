@extends('layout.app')

@section('title')
VGN: Awards
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Awards">
<meta name="description" content="Awards">
<meta name="keywords" content="Awards">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='VGN Awards'/>
<meta property='og:description' content='Awards'/>
<meta property='og:url' content='http://vgn.in/awards'/>
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
    <link href="{{ config('app.AWS_URL')}}/assets/libs/lightbox2-master/dist/css/lightbox.css" rel="stylesheet">

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

.card .card-action {
border-top: 1px solid rgba(160, 160, 160, 0.2);
padding: 10px;
height: 80px !important;
text-align: center;
}

.card
{
  margin: 5px 0px;
}
.card a { 
      font-weight: 500;
    color: #F44336;
    font-size: 16px;
  }
  .card a:hover 
  {
color: #F44336;
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
  <li>Awards and Honours</li>
</ul>
</div>
        </div>
      

        <div class="row">

 <div class="col s12 m3">
                    
                <div class="card">
                 
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/ET_awards_2021_1.jpg"  data-lightbox="VGN Awards" data-title=" Economic Times BB Reality 2021 ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/ET_awards_2021_1.jpg">
                    </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/ET_awards_2021_1.jpg"  data-lightbox="VGN Awards" data-title=" Economic Times BB Reality 2021 ">Economic Times BB Reality 2021</a>
                  </div>

                </div>
                
              </div>

                  <div class="col s12 m3">
                    
                <div class="card">
                 
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/Aircel Super Cup.JPG"  data-lightbox="VGN Awards" data-title=" Aircel Super Cup ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Aircel Super Cup.JPG">
                    </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Aircel Super Cup.JPG"  data-lightbox="VGN Awards" data-title=" Aircel Super Cup ">Aircel Super Cup</a>
                  </div>

                </div>
                
              </div>

              <div class="col s12 m3">
                
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Chennai Super Kings - Super Cup.JPG"  data-lightbox="VGN Awards" data-title=" Chennai Super Kings Super Cup winner ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Chennai Super Kings - Super Cup.JPG">
                    </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Chennai Super Kings - Super Cup.JPG"  data-lightbox="VGN Awards" data-title=" Chennai Super Kings Super Cup winner ">Chennai Super Kings Super Cup winner</a>
                  </div>
                </div>
              
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/V Raman Memorial Cup.JPG"  data-lightbox="VGN Awards" data-title=" V Raman Memorial Cup 2017 ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/V Raman Memorial Cup.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/V Raman Memorial Cup.JPG"  data-lightbox="VGN Awards" data-title=" V Raman Memorial Cup 2017 ">V Raman Memorial Cup 2017</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/South Indias Real Estate.JPG"  data-lightbox="VGN Awards" data-title=" South India’s real estate Awards - Developers of the Year 2017 ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/South Indias Real Estate.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/South Indias Real Estate.JPG"  data-lightbox="VGN Awards" data-title=" South India’s real estate Awards - Developers of the Year 2017 ">South India’s real estate Awards - Developers of the Year 2017</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/Vijayavani Property Expo.JPG"  data-lightbox="VGN Awards" data-title=" Vijayavani Property Expo Awards 2015 ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Vijayavani Property Expo.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Vijayavani Property Expo.JPG"  data-lightbox="VGN Awards" data-title=" Vijayavani Property Expo Awards 2015 ">Vijayavani Property Expo Awards 2015</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Zenith.JPG"  data-lightbox="VGN Awards" data-title=" Zenith Cultural Fest Award ">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Zenith.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Zenith.JPG"  data-lightbox="VGN Awards" data-title=" Zenith Cultural Fest Award ">Zenith Cultural Fest Award</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Indian Express Expanding Metropolis.JPG"  data-lightbox="VGN Awards" data-title="Indian Express Property Expo Awards">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Indian Express Expanding Metropolis.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Indian Express Expanding Metropolis.JPG"  data-lightbox="VGN Awards" data-title="Indian Express Property Expo Awards">Indian Express Property Expo Awards</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/India Bulls Premier League.JPG"  data-lightbox="VGN Awards" data-title="India Bulls premier League Awards 2016">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/India Bulls Premier League.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/India Bulls Premier League.JPG"  data-lightbox="VGN Awards" data-title="India Bulls premier League Awards 2016">India Bulls premier League Awards 2016</a>
                  </div>
                </div>
              </div>



              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Prince Of Arcot Trophy.JPG"  data-lightbox="VGN Awards" data-title="Prince of Arcot Trophy Runners Up 2013">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Prince Of Arcot Trophy.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Prince Of Arcot Trophy.JPG"  data-lightbox="VGN Awards" data-title="Prince of Arcot Trophy Runners Up 2013">Prince of Arcot Trophy Runners Up 2013</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Prince of Arcot Trophy 2014.JPG"  data-lightbox="VGN Awards" data-title="Prince of Arcot Trophy Runners Up 2014">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Prince of Arcot Trophy 2014.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Prince of Arcot Trophy 2014.JPG"  data-lightbox="VGN Awards" data-title="Prince of Arcot Trophy Runners Up 2014">Prince of Arcot Trophy Runners Up 2014</a>
                  </div>
                </div>
              </div>

              

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/SAP Invitional Cup.JPG"  data-lightbox="VGN Awards" data-title="SAP invitational F15 Cricket Cup winner">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/SAP Invitional Cup.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/SAP Invitional Cup.JPG"  data-lightbox="VGN Awards" data-title="SAP invitational F15 Cricket Cup winner">SAP invitational F15 Cricket Cup winner</a>
                  </div>
                </div>
              </div>

              

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/LIC HFL.JPG"  data-lightbox="VGN Awards" data-title="LIC HFL Ungal Illam awards 2017">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/LIC HFL.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/LIC HFL.JPG"  data-lightbox="VGN Awards" data-title="LIC HFL Ungal Illam awards 2017">LIC HFL Ungal Illam awards 2017</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Economic Times Realty Convention.JPG"  data-lightbox="VGN Awards" data-title="Economic Times Reality Convention Awards">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Economic Times Realty Convention.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Economic Times Realty Convention.JPG"  data-lightbox="VGN Awards" data-title="Economic Times Reality Convention Awards">Economic Times Reality Convention Awards</a>
                  </div>
                </div>
              </div>

               <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/HDFC Devloper of the Year.JPG"  data-lightbox="VGN Awards" data-title="HDFC Preferred Developer Award">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/HDFC Devloper of the Year.JPG">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/HDFC Devloper of the Year.JPG"  data-lightbox="VGN Awards" data-title="HDFC Preferred Developer Award">HDFC Preferred Developer Award</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/LIC HFL Ungal Illam awards 2013.jpg"  data-lightbox="VGN Awards" data-title="LIC HFL Ungal Illam awards 2013">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/LIC HFL Ungal Illam awards 2013.jpg">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/LIC HFL Ungal Illam awards 2013.jpg"  data-lightbox="VGN Awards" data-title="LIC HFL Ungal Illam awards 2013">LIC HFL Ungal Illam awards 2013</a>
                  </div>
                </div>
              </div>
              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                     <a href="{{ config('app.AWS_URL')}}/images/awards/Maddys - Advertising Club.jpg"  data-lightbox="VGN Awards" data-title="Maddys - Advertising club Madras Daily Thanthi – TV and Radio Awards 2017">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Maddys - Advertising Club.jpg">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Maddys - Advertising Club.jpg"  data-lightbox="VGN Awards" data-title="Maddys - Advertising club Madras Daily Thanthi – TV and Radio Awards 2017">Maddys - Advertising club Madras Daily Thanthi – TV and Radio Awards 2017</a>
                  </div>
                </div>
              </div>

              <div class="col s12 m3">
                <div class="card">
                  <div class="card-image">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Sulekha Awards.jpg"  data-lightbox="VGN Awards" data-title="Lifetime Achievement Award by Sulekha Properties">
                    <img src="{{ config('app.AWS_URL')}}/images/awards/Sulekha Awards.jpg">
                  </a>
                  </div>
                  
                  <div class="card-action">
                    <a href="{{ config('app.AWS_URL')}}/images/awards/Sulekha Awards.jpg"  data-lightbox="VGN Awards" data-title="Lifetime Achievement Award by Sulekha Properties">Lifetime Achievement Award by Sulekha Properties</a>
                  </div>
                </div>
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
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    
  <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
  <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
   
<script src="{{ config('app.AWS_URL')}}/assets/libs/lightbox2-master/dist/js/lightbox.js"></script>

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
