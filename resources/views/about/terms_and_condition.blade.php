@extends('layout.app')

@section('title')
VGN:Terms and Conditions
@endsection

@section('description')
<META NAME="Subject" CONTENT="Terms and Conditions">
<meta name="description" content="VGN Terms and Conditions">
<meta name="keywords" content="VGN Terms and Conditions">
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

h3.about-subtitle {
  font-size: 18px;
  margin-bottom: 16px;

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
  <li>Terms and Conditions</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-12">
              <div class="person-about">
                <h3 class="about-subtitle">Terms and Conditions</h3>
                <p ><i class="fa fa-diamond" style="color:red;"></i> By visiting our website and accessing the information, resources, services, products, and tools we provide for you, either directly or indirectly (hereafter referred to as 'Resources'), you agree to use these Resources only for the purposes intended and permitted by:</p>
                <ul>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> The terms of this User Agreement</p></li>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Applicable laws, regulations and generally accepted online practices or guidelines.</p></li>
                </ul>
                <p>Wherein, you understand that:</p>
                <ul>
                <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> In order to access our Resources, you may be required to provide certain information about yourself (such as identification, contact details, etc.) as part of the registration process, or as part of your ability to use the Resources. You agree that any information you provide will always be accurate, correct, and up-to-date.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> You are responsible for maintaining the confidentiality of any login information associated with any account you use to access our Resources. Accordingly, you are responsible for all activities that occur under your account/s.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Accessing (or attempting to access) any of our Resources by any means other than through the means we provide, is strictly prohibited. You specifically agree not to access (or attempt to access) any of our Resources through any automated, unethical or unconventional means.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Engaging in any activity that disrupts or interferes with our Resources, including the servers and/or networks to which our Resources are located or connected, is strictly prohibited.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Attempting to copy, duplicate, reproduce, sell, trade, rent or resell our Resources is strictly prohibited.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> You are solely responsible for any consequences, losses, or damages that we may directly or indirectly incur or suffer due to any unauthorized activities conducted by you, as explained above, and may incur criminal or civil liability.</p></li>
<li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> •  You agree to indemnify and hold harmless VGN PROJECTS ESTATES PRIVATE LIMITED and its subsidiaries and affiliates, and their directors, officers, managers, employees, donors, agents, and licensors, from and against all losses, expenses, damages and costs, including reasonable attorneys' fees, resulting from any violation of this User Agreement or the failure to fulfil any obligations relating to your account incurred by you or any other person using your account. We reserve the right to take over the exclusive defense of any claim for which we are entitled to indemnification under this User Agreement. In such event, you shall provide us with such cooperation as is reasonably requested by us.</p></li>
<h3 class="about-subtitle">Trademark Notice</h3>
<p>All of the trademarks, service marks and logos displayed on this website (the "Trademark(s)") are registered and unregistered trademarks of VGN PROJECTS ESTATES PRIVATE LIMITED. Except as expressly stated in these terms and conditions, you may not reproduce, display or otherwise use any Trademark without first obtaining a written permission from VGN PROJECTS ESTATES PRIVATE LIMITED. You agree not to affect / interrupt or attempt to affect / interrupt the operation of this website in any manner.</p>

<h3 class="about-subtitle">Unsolicited Ideas</h3>
<p>VGN PROJECTS ESTATES PRIVATE LIMITED welcomes your comments and feedback regarding this website and/or its contents. All information and materials, including comments, ideas, questions, designs, and the like, submitted to VGN PROPERTY DEVELOPERS PRIVATE LIMITED through this website will be considered NON-CONFIDENTIAL and NON-PROPRIETARY. For this reason, we ask you not to send us any information or materials that you do not wish to assign to us, including any confidential information.</p>
<h3 class="about-subtitle">Limitations of Liability</h3>
<p>Your use of this website is at your sole risk. Under no circumstances, shall VGN PROJECTS ESTATES PRIVATE LIMITED, be liable for any direct or indirect losses or damages arising out of or in connection with your use of or inability to use this website or your reliance on any information provided on this website. This is a comprehensive limitation of liability that applies to all losses and damages of any kind whatsoever, whether direct or indirect, general, special, incidental, consequential, exemplary or otherwise, including without limitation, loss of data, revenue or profits.</p>

<h3 class="about-subtitle">Entire Agreement</h3>
<p>This Agreement constitutes the entire agreement between you and VGN PROJECTS ESTATES PRIVATE LIMITED with respect to your access to and/or use of this website.</p>



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
