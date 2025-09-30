@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Payment response
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }

		svg {
  width: 70px;
  display: block;
  margin: 20px auto 0;
}
.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.path.circle {
  -webkit-animation: dash 0.9s ease-in-out;
  animation: dash 0.9s ease-in-out;
}
.path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash 0.9s 0.35s ease-in-out forwards;
  animation: dash 0.9s 0.35s ease-in-out forwards;
}
.path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check 0.9s 0.35s ease-in-out forwards;
  animation: dash-check 0.9s 0.35s ease-in-out forwards;
}
#responsecard h2 {
  text-align: center;
  margin: 20px 0 0px;
}
#responsecard h3 {
  text-align: center;
  margin: 20px 0 0px;
	font-weight: 200;
}
#responsecard p {
  text-align: center;
  margin: 20px 0 0px;
  font-size: 1.25em;
}
#responsecard p.success {
  color: #73AF55;
}
#responsecard p.error {
  color: #D06079;
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
#responsecard .heading {
    font-weight: 400;
    text-transform: uppercase;
    font-size: 22px;
		text-align:center;
}
#responsecard .para{
	text-align:center;
}

.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}


.content-wrapper{
	margin-left: 0px;
}

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  /* change if the mask should have another color then white */
  z-index: 99;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url("{{ config('app.AWS_URL')}}/images/Preloader.gif");
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red ">

<!-- Site wrapper -->
<div class="wrapper">



 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
    <!-- Main content -->
    <section class="content">

		
			
	



<div class="row" style="margin-top:50px;">
		
	
		
    <div class="col-md-6 col-md-offset-3">
      
      <div class="box box-danger">
			
			@if(count($paymentres) > 0)
			<div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-credit-card margin-r-5"></i> VGN Online Payment </h3>
            </div>
			@else
			
			@endif




            
            <!-- /.box-header -->
            <div class="box-body">
													


@if(count($paymentres) > 0)
@foreach($paymentres as $k=>$v)
<div class="col-md-12 card" style="margin-bottom:50px;padding:50px;" id="responsecard">
@if($v->payment_code == '0300')
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
  <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
  <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
</svg>
@else
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
  <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
</svg>
@endif
							<h2><i class="fa fa-rupee"></i> {{$v->paymentamount}}</h2>
							@if($v->payment_code == '0300') <h3>Payment Successful</h3>@else <h3>Payment Failed</h3> @endif
			<h3 class="heading">Transaction Details</h3>	
				@if($v->ismaintenance == '1111')<p class="para">Payment For: Apartment Maintenance Charges</p>@endif	
			<p class="para">Application Number: {{$v->application_number}}</p>
			<p class="para">Reference Number: {{$v->payment_referenceid}}</p>
			<p class="para">Date & Time: {{$v->paymentdatetime}}</p>		
			<p class="para">Amount: <i class="fa fa-rupee"></i> {{$v->paymentamount}}</p>
			<p class="para">Project Name: VGN {{$v->plant_name}}</p>
			<p class="para">Unit Name: {{$v->unit_name}}</p>
		
			@if($v->payment_code != '0300')
			<p class="para">Reason: {{$v->payment_description}}</p>
			@endif
			</div>
			@endforeach
							@endif


							
               
               
                
							
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">

$(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
});
				$(document).ready(function(){
                    
												$('.sidebar-menu').tree();
																												
													
													
				});				
		    </script>
@endsection
