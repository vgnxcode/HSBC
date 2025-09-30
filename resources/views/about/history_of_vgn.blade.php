@extends('layout.app')

@section('title')
Mr. Pratish Vedhappudi | Managing Director of VGN Group
@endsection

@section('description')
   
<META NAME="Subject" CONTENT="Mr. Pratish Vedhappudi">
<meta name="description" content="Mr. Pratish Vedhappudi, the young and vibrant Managing Director of VGN Group is fond of establishing captivating elegant living areas for patrons that describe style and convenience.">
<meta name="keywords" content="Successful realtors in chennai, Best builder, Mr. Pratish Vedhappudi, Managing Director of VGN Group ">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Mr. Pratish Vedhappudi | Managing Director of VGN Group'/>
<meta property='og:description' content='Mr. Pratish Vedhappudi, the young and vibrant Managing Director of VGN Group is fond of establishing captivating elegant living areas for patrons that describe style and convenience.'/>
<meta property='og:url' content='{{ url()->full() }}/history_of_vgn'/>
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



    
    <section id="coreteam" class="scroll-section root-sec brand-bg padd-tb-60 testimonial-wrap">
      <div class="container">
        <div class="row">
          <div class="coreteam-inner">
            <div class="col-sm-12 card-box-wrap">
              
                

                <div class="clearfix contact-form">
                  <div class="row" style="margin-top: 40px; text-align:center;">
                    <div class="col-sm-12">
                    <h1 class="title" style="font-size:41px;font-weight: 500; text-decoration: underline;">History</h1>
                   
                  </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-12 col-md-3" >
                    <div class="card">
  <div class="card-header">
    <img src="{{ config('app.AWS_URL')}}/images/coreteam/v_guruswamy_vgn_founder.jpg"/>
  </div>
 
  
</div>
                  </div>

                  <div class="col-sm-12 col-md-9 maincore">
                
    <h2 class="sub-title">MR. V. GURUSAMY (1896 to1966) - <small class="subtext">FOUNDER</small></h2>
    
    <p>V. Gurusamy is the founder of VGN group. In the year 1942 he started a brick kiln factory and manufactured bricks in the name of VGN. He acquired land parcels basically to manufacture bricks in various locations. He worked hard to build good will and earned a name for VGN brand.</p>
                    
                  </div>
            </div>

<br />
                <!-- <div class="row">
                  <div class="col-sm-12 col-md-3" >
                    <div class="card">
  <div class="card-header">
    <img src="{{ config('app.AWS_URL')}}/images/coreteam/chairman_pic.jpg"/>
  </div>
 
  
</div>
                  </div>

<div class="col-sm-12 col-md-9 maincore">

<h2 class="sub-title">MR. V.N. DEVADOSS - <small class="subtext">CHAIRMAN</small></h2>

<p>A seasoned entrepreneur and the vision behind the group, he is known for his sharp business acumen and experience in the field. With over 36 years’ experience in the real estate industry, he has spearheaded the company to great heights and has consistently delivered high returns to all VGN customers for decades, surpassing any other investment avenues available in the market today.</p>

</div>
</div>

<br /> -->
<div class="row">
<div class="col-sm-12 col-md-3" >
<div class="card">
<div class="card-header">
<img src="{{ config('app.AWS_URL')}}/images/coreteam/md_pic.jpg"/ alt="Mr. Pratish Vedhappudi - Managing Director of the VGN group">
</div>


</div>
</div> 

                  <div class="col-sm-12 col-md-9 maincore">
                
    <h2 class="sub-title">MR. PRATISH VEDHAPPUDI - <small class="subtext">MANAGING DIRECTOR</small></h2>
    
                   <p>Mr. Pratish Vedhappudi entered into the real estate business at a very young age from the year 2004. He wanted to implement his dream of venturing into property development and construction of large residential projects in and around Chennai. Since 2008, he has embarked into large residential townships in various parts of Chennai. His motto is to help thousands of families realize their dream of owning a ‘Home’ and also provide exponential returns on their investments in VGN properties . Under his leadership, VGN group has completed over 600 acres of plotted development, consisting of 20,000 residential plots . The company has also delivered around 10,500 apartments under his dynamic leadership. He is the owner of VGN Group.</p>
                  </div>
            </div>
                

                </div>
              

              
            </div>
          </div>
        </div>

        
      </div> <!-- ./container end -->
    </section>

 
 <!-- Funfacts Section end -->
    


    
<!--Section: Team v.1-->


 

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
    $(".title").css('font-size','34px');
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
