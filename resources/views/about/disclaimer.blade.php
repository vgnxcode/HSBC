@extends('layout.app')

@section('title')
VGN:Disclaimer
@endsection

@section('description')
<META NAME="Subject" CONTENT="Disclaimer">
<meta name="description" content="Disclaimer details">
<meta name="keywords" content="Disclaimer">
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
  <li>Disclaimer</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-12">
              <div class="person-about">
                <h3 class="about-subtitle">Disclaimer</h3>
                <p style="text-align:justify; margin-bottom:5px;font-size:16px;"><i class="fa fa-diamond" style="color:red;"></i> All project information and details displayed on the site, including but not limited to the information and details contained in project related materials that you may download are for information purposes only and do not constitute an offer under any law for the time being in force. The Company shall not be liable for any decisions you may take as a result of or on the basis of such information and encourages you to contact the Company directly for updated and accurate information. The artistic work contained in this web site like 360 degree view, elevations, walk-through, E-Brochures, other similar material may have been digitally enhanced or altered and may not represent actual views except expressly stated otherwise. These are for indicative purpose only. Changes may be made during the development of a real estate project and standard fittings and specifications are subject to change without notice. Standard fittings and finishes are subject to availability and vendor's discretion. Fittings, finishes and fixtures shown in the images contained herein are not standard and will not be provided as part of an apartment. Soft furnishing/furniture, gadgets are not part of the offering unless otherwise mentioned. The information contained herein is believed to be correct but is not guaranteed. Prospective purchasers should make and must rely on their own enquiries. The colours of the buildings are indicative only. Any of the contents of this website is a guide only and do not constitute an offer or contract.</p><p style="text-align:justify;margin-bottom:5px;font-size:16px;"><i class="fa fa-diamond" style="color:red;"></i> In no event shall VGN PROJECTS ESTATES PRIVATE LIMITED and its related, affiliated and subsidiary companies be liable for any direct, indirect, special, incidental, or consequential damages arising out of the use of the information contained herein.</p>
                
              </div>

             </div>
            <!-- about me description -->

            <!-- about me image -->

           
            <!-- about me info -->

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
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
	    <script>
 $(document).ready(function() {
 
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
