@extends('layout.app')

@section('title')
VGN: Contact Us
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Contact Us">
<meta name="description" content="Contact Us">
<meta name="keywords" content="Contact Us, VGN Address, VGN Call, Contact Number">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='Contact Us'/>
<meta property='og:description' content='Contact Us'/>
<meta property='og:url' content='http://vgn.in/contact_us '/>
<meta property='og:site_name' content='VGN Projects Estates Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')
   
@endsection

@section('stylesheet')
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

	<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert/sweet-alert.css')}}">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>

 .select-wrapper span.select-dropdown{
        color: #000;
        border-bottom: 1px solid #4CAF50;
        box-shadow: 0 1px 0 0 #4caf50;
      }

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



    <section id="about" class="scroll-section root-sec padd-tb-60 brand-bg lighten-5 about-wrap breadlist" style="padding-top:90px;">
      <div class="container">

        
        
       <div class="row">

          <div class="col-sm-12 col-md-12">
              <div class="person-about">
                <div class="row">
        <h2 class="title" style="color:#fff;">Contact Us</h2>
        </div>



<div class="row">
  <div class="col-md-1"></div>
                   <a href="tel:04443439999" style="color:#F44336;line-height: 2.2rem;">
      <div class="card-panel white col-md-3 col-sm-12" style="margin:2px;">

        <h1 class=" card-title" style="font-size: 1.2rem;font-weight:500;"><i class="fa fa-phone-square"></i> For Sales Enquiry</h1>
        <h4 style="color:#F44336;">Call 044-43439999</h4>
      </div></a>

      <a href="tel:04443439977" style="color:#F44336;line-height: 2.2rem;">
      <div class="card-panel white col-md-3 col-sm-12" style="margin:2px;">
        <h1  style="font-size: 1.2rem;font-weight:500;"><i class="fa fa-phone-square" ></i> For Customer Care Enquiry</h1>
        <h4 style="color:#F44336;">Call 044-43439977</h4>
  </div></a>
  <a href="tel:04443439900" style="color:#F44336; line-height: 2.2rem;">
  <div class="card-panel white col-md-4 col-sm-12" style="margin:2px;">
        <h1 style="font-size: 1.2rem;font-weight:500;"><i class="fa fa-phone-square"></i> For Vendors & Other Enquiry</h1>
        <h4>Call 044-43439900</h4>
      </div></a>
<div class="col-md-1"></div>
    </div>


    <div class="row">
<div class="col-md-1"></div>
<div class="card-panel white col-md-10 col-sm-12" style="color:#F44336;">
        <div class="row">
            
        <h1  style="font-size: 1.2rem;font-weight:500;margin-bottom: 3px;text-align: center;"><i class="fa fa-users" ></i> For Land Owners</h1>

        <p  style="line-height: 1.2rem;color: #F44336;text-align: center;">(For land owners, who are willing to sell their land/develop properties on joint venture basis.)</p>

<form class="col s12" action="{{ url('/landowners') }}" method="post" style="color:#000;">
  @if($errors->count() > 0)
    <div id="ERROR_COPY" style="display: none;" class="alert alert-danger">
      <ol>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ol>
    </div>
  @endif
{{csrf_field()}}
      <div class="row">
                      <div class="input-field col s10 m4">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}" required="true">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Name">Name of the land owner*</label>
                    </div>                     
                    
                    <!-- <div class="input-field col s10 m4">
                        <input id="Mobile" type="text" name="Mobile" class="validate" value="{{ old('Mobile')}}" required="true">
                        {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile Number*</label>
                    </div> -->

                    <div class="input-field col s10 m4">
                        <!-- <label for="Mobile" class="col-sm-4 control-label">Mobile Number*</label> -->
                        <div class="col-sm-12">
                          <input type="text" class="form-control" name="Mobile" id="Mobile" value="{{old('Mobile')}}" required="true">
                          <label for="Mobile">Mobile Number*</label>
                          <!-- <span id="lblmobileCard" class="error">Mobile Number already registered</span> -->
                          <span class="text-success pull-right verifytext" style="font-size: bold;"><i class="fa fa-check"></i> Verified</span>
                          <button class="btn btn-warning pull-right" type="button" id="getmobileotp">Get Mobile OTP</button>
                          {!! $errors->first('Mobile', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                    </div>
                    <div style="text-align:center" id="loadergif">
                        <img src="{{ config('app.AWS_URL')}}/images/loader11.gif" alt="loader" width="60">
                    </div>
                    <div class="input-field col s10 m4" id="verifymobilediv">
                        <!-- <label for="mobileotp" class="col-sm-4 control-label">Verify Mobile Number (Mobile)*</label> -->
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="mobileotp" name="mobileotp" aria-label="Enter Mobile OTP" >
                          <label for="Mobile">Enter Mobile OTP</label>
                          <button class="btn btn-danger pull-right" type="button" id="verifymobileotp"><i class="fa fa-check"></i> Verify Mobile</button>
                        </div>
                    </div>
                      
                     <div class="input-field col s10 m4">
                        <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}" >
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email (optional)</label>
                    </div>

                    


                    </div>

                     <div class="row">
                      <div class="input-field col s10 m4">
                        <input id="Location" type="text" name="Location" class="validate" value="{{ old('Location')}}" required="true">
                        {!! $errors->first('Location', '<span class="errortext">:message</span>') !!}
                        <label for="Location">Land Location*</label>
                    </div>                     
                    

                      
                     

                    <div class="input-field col s10 m4">
                        <input id="Extent" type="text" name="Extent" class="validate" value="{{ old('Extent')}}" required="true">
                        {!! $errors->first('Extent', '<span class="errortext">:message</span>') !!}
                        <label for="Extent">Land Extent in (Acres/Grounds)*</label>
                    </div>

                     <div class="input-field col s10 m2">
                       <select class="validate" name="extent_type" id="extent_type" required="true" style="color: #000;">
      <option value="Acres" selected>Acres</option>
      <option value="Grounds">Grounds</option>
    </select>
    
                    </div>

                    <div class="col s10 m2"></div>


                    </div>

                    <div class="row" style="text-align: center;">
                      <div class="input-field col s10 m3"></div>
                      <div class="input-field col s10 m6">
                    <button type="submit" class="waves-effect waves-light btn red white-text" ><i class="fa fa-send" style="font-size: 15px;"></i> Submit</button>
                    </div>

                    </div>

</form>



      </div>
        </div>
        <div class="col-md-1"></div>
      
    </div>


    <div class="row">
<div class="col-md-1"></div>
<div class="card-panel white col-md-10 col-sm-12" style="color:#F44336;">
        <div class="row">

          <div class="col-md-5">
            <div class="card-panel white" style="color:#F44336;margin-top:3px;">
        <h1  style="font-size: 1.6rem;font-weight:400;"><i class="fa fa-map-marker" ></i>  Office Address</h1>
        <br/><h5  style="line-height: 1.5rem;font-size: 1.3rem;font-weight: 300;">Y - 222, VGN Kimberly Towers,
        </br>2nd Avenue, Y block,
        </br>Anna Nagar , 
        </br>Chennai - 600040.</h5>
      </div>
          </div>
          <div class="col-md-7">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7773.204499437169!2d80.248525!3d13.060971!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6c9abb4bc5649a04!2sVGN%20Projects%20Estates%20Private%20Limited!5e0!3m2!1sen!2sus!4v1575716383142!5m2!1sen!2sus" frameborder="0" style="border:0;padding: 0px;" id="map" allowfullscreen="" class="img-responsive card googlemap"></iframe>
          </div>

        </div>
      </div>
<div class="col-md-1"></div>
    </div>





      </div>
          </div>
        </div>



      </div>
            
    </section>
    

    
    

 
 

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
   <script src="{{ asset('assets/libs/sweetalert/sweet-alert.min.js')}}"></script>
    
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

var has_errors = {{ ($errors->count() > 0) ? 'true' : 'false'}};
 if (has_errors) {
  console.log($("#ERROR_COPY").html());
  swal({
  title: "Errors!",
  type: "error",
  text: $("#ERROR_COPY").text(),
  showCloseButton: true
});
  $("#Name").focus();
 }



 $("#verifymobilediv").hide();
    $("#loadergif").hide();
    $(".verifytext").hide();

    $("#getmobileotp").on("click", function () {


    $("#loadergif").show();


    var mobileno = $("#Mobile").val();


    if (mobileno != '') {
    $("#lblmobileCard").css("visibility", "hidden");
    $.post('/vendorzone/sendandsavevendor_registerotp', {
    _token: "{{csrf_token()}}",
    mobileotp: mobileno
    }, function (data) {

    $("#loadergif").hide();

    var res = JSON.parse(data);

    if (res.status == 1) {
      $("#getmobileotp").text('Resend OTP');

      $("#verifymobilediv").fadeIn(() => {
        $("#verifymobilediv").show();
      });


    } else if (res.status == 2) {
      $("#loadergif").hide();
      alert('Too Many attempts requested for OTP. Try after 30 Minutes!');
    } else if (res.status == 3) {
      $("#loadergif").hide();
      alert('Invalid Mobile Number!');
    } else if (res.status == 4) {
      $("#loadergif").hide();
      $("#Mobile").val('');
      $("#Mobile").addClass('errorcolor');
      $("#lblmobileCard").text('');
      //$("#lblmobileCard").text(`Vendor already exists for this Mobile Number!`);
      //$(".verifytextpan").hide();
      $("#lblmobileCard").css("visibility", "visible");
      //alert('Mobile Number already registered!');
    } else if (res.status == 5) {
      $("#loadergif").hide();
      $("#Mobile").val('');
      $("#Mobile").addClass('errorcolor');
      $("#lblmobileCard").text('');
     // $("#lblmobileCard").text(`Vendor Registration is in process for this Mobile Number!`);
      //$(".verifytextpan").hide();
      $("#lblmobileCard").css("visibility", "visible");
      //alert('Mobile Number already registered!');
    } else {
      $("#loadergif").hide();
      alert('Mobile OTP not sent. Try Again!');
    }
    });


    } else {
    alert('Mobile Number should not be empty!');
    $("#Mobile").focus();
    $("#loadergif").hide();
    }


    });


    $("#verifymobileotp").on("click", function () {

    var mobileotp = $("#mobileotp").val();
    var mobileno1 = $("#Mobile").val();
    if (mobileotp != '') {
    $.post('/vendorzone/validatemobileotp', {
    _token: "{{csrf_token()}}",
    mobileotpbyuser: mobileotp,
    mobileno1: mobileno1
    }, function (data1) {

    var newdata1 = JSON.parse(data1);

    if (newdata1.otpverified == 0) {
      $("#mobileotp").addClass('errorcolor');
      $("#Mobile").removeClass('successcolor');
      
    } else {
      $("#mobileotp").removeClass('errorcolor');
      $("#Mobile").removeClass('errorcolor');
      $("#Mobile").addClass('successcolor');
      $("#Mobile").attr('readonly', true);


      $("#verifymobilediv").hide();
      $("#getmobileotp").hide();
      $(".verifytext").show();


    }
    });
    } else {
    alert('Enter Mobile OTP to verify!');
    $("#loadergif").hide();
    }


    });
 
});
</script>

@if(session()->has('suc_msg'))
    <script>
    swal({
  title: "Successfully Submitted!",
  text: "Thanks for your interest. We will get back to you shortly.",
  type: "success"
});
</script>

@endif
@if(session()->has('error_msg'))
<script>
  swal({
    title: "The mobile number is not verified.",
    text: "Try again!",
    type: "error"
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
  $("#map").css('margin-top', '3px');
}
</script>
@endsection
