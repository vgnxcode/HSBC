@extends('layout.app')

@section('title')
VGN:Privacy Policy
@endsection

@section('description')
<META NAME="Subject" CONTENT="Privacy Policy">
<meta name="description" content="VGN Privacy Policy">
<meta name="keywords" content="Privacy Policy">
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
  <li>Privacy Policy</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-12">
              <div class="person-about">
                <h3 class="about-subtitle">Privacy Policy</h3>
                <p ><i class="fa fa-diamond" style="color:red;"></i> This Privacy Policy governs the manner in which VGN PROJECTS ESTATES PRIVATE LIMITED and its subsidiaries, partners, agents and affiliates collect, use, maintain and disclose information collected from users of their website and microsite.</p>
                <h3 class="about-subtitle">Personal identification information</h3>
                <p><i class="fa fa-diamond" style="color:red;"></i> We may collect personal identification information from Users in a variety of ways, including, but not limited to:
                  <ul>
                 <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> when Users visit our site, subscribe to the newsletter, fill out a form, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number. Users may, however, visit our Site anonymously. Users can always refuse to supply
personal identification information, except that it may prevent them from engaging in certain Site related activities.</p></li></ul>
                </p>
                <h3 class="about-subtitle">Non-personal identification information</h3>
                <p ><i class="fa fa-diamond" style="color:red;"></i> We may collect non-personal identification information about Users whenever they interact with our Site. Non personal identification information may include the browser name, the type of computer and technical information about Users, means the type of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>
                  <h3 class="about-subtitle">Web browser cookies</h3>
                <p ><i class="fa fa-diamond" style="color:red;"></i> Our Site may use "cookies" to enhance User experience. The user's web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. The user may choose to set their web browser to refuse cookies, or to alert the Users when cookies are being sent. If they do so, note that some parts of the Site may not function properly. This is a standard operating procedure that is used across the internet.</p>
                 <h3 class="about-subtitle">How we use collected information</h3>
                <p ><i class="fa fa-diamond" style="color:red;"></i> VGN PROJECTS ESTATES PRIVATE LIMITED may collect and use User’s personal information for the following purposes:</p>

                
<p>
  <ul>
    <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> To improve customer service: Information provided by Users helps us respond to the customer service requests and support needs, more efficiently.</p></li>
     <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> To personalize User experience: We may use the information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</p></li>
     <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> To improve our Site: We may use the feedback provided by the Users to improve our products and services.</p></li>
     <li><p><i class="fa fa-hand-o-right" aria-hidden="true" ></i> To run a promotion, contest, survey or other Site feature.</p></li>
     <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> To send the Users information, which they agreed to receive, about topics of interest to them.</p></li>
     <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> To send periodic emails.</p></li>

</ul>
</p>

<h3 class="about-subtitle">How we protect User’s information:</h3>
<p ><i class="fa fa-diamond" style="color:red;"></i> We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of User’s personal information and data stored on our Site. As with data security, there are limits to its effectiveness and we indemnify ourselves in the event of an attack that is difficult to defend against. We also will do our best to retrieve any data that is lost as per available resources.</p>
<h3 class="about-subtitle">Sharing personal information of Users</h3>
<p ><i class="fa fa-diamond" style="color:red;"></i> We do not sell, trade, or rent Users’ personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding Users with our subsidiaries, our business partners, trusted affiliates and advertisers for the purposes outlined above.</p>
<h3 class="about-subtitle">Changes to this privacy policy</h3>
<p ><i class="fa fa-diamond" style="color:red;"></i> VGN PROJECTS ESTATES PRIVATE LIMITED shall update this privacy policy at its sole discretion. Users are advised to check this page for any changes in the privacy policy and to stay informed about how the personal information of the Users is protected by us. The Users hereby acknowledge and agree that it is their responsibility to review this privacy policy periodically and become aware of changes/modifications.</p>
<h3 class="about-subtitle">Your acceptance of these terms</h3>
<p ><i class="fa fa-diamond" style="color:red;"></i> By using this Site, the Users record their acceptance of this policy, as may be modified from time to time. The Users are advised not to access this site if they do not agree to our privacy policy. The above mentioned privacy policy shall be applicable to the information and data collected by our call centers as well.</p>
<h3 class="about-subtitle">Contacting us</h3>
<p ><i class="fa fa-diamond" style="color:red;"></i> If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us.</p>


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
