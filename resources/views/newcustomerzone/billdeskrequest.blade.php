@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Online Payment Page
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
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getcustomerdata as $customer)


 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
    <!-- Main content -->
    <section class="content">

		
		@if(count($paymentres) > 0)
		@else
		<div class="row">
		<div class="col-md-10 col-md-offset-1">
		
	@include('newcustomerzone.contenttop')
	

      	</div>
	</div>
		@endif
	
	


@if(count($paymentres) > 0)
<div class="row" style="margin-top:50px;">
		@else
<div class="row">
@endif
	
		
    <div class="col-md-6 col-md-offset-3">
      
      <div class="box box-danger">
			
			@if(count($paymentres) > 0)
			<div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-credit-card margin-r-5"></i> Online Payment </h3><span class="pull-right" ><a href="{{ url('/customerzone/payonline') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward"></i> Payment Page</a></span>
            </div>
			@else
			<div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-credit-card margin-r-5"></i> Online Payment </h3><span class="pull-right" ><a href="{{ url('/customerzone/paymenthistory') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Payment History</a></span>
            </div>
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

<div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>

							
               
               
                
							@if(count($paymentres) > 0)
							<form id="billdeskform" method="POST" action="{{ url('/customerzone/payonline') }}" class="form-horizontal" style="display:none;" autocomplete="off" >
							@else
							<form id="billdeskform" method="POST" action="{{ url('/customerzone/payonline') }}" class="form-horizontal" autocomplete="off" >
							@endif
                
                {{ csrf_field() }}
                   <div class="row">
                       <div class="col-lg-8  col-lg-offset-2">
                                <div class="form-group">
												<label for="project" >Project Name</label>
												<div>
													<select class="form-control userdropdown" name="project" id="Projects">
														<option value="">Select*</option> 
													</select>
													{!! $errors->first('project', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="unit">Unit No</label>
												<div>
													<select class="form-control userdropdown" name="unit" id="Units" required>
															<option value="">Select</option>
														</select>
													{!! $errors->first('unit', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>

                      <div class="form-group" id="netbaldiv">
												<label for="amountpending">Net Balance Amount</label>
												
													<div>
													<div class="input-group">
													<div class="formloader" id="formloader1" style="text-align:center;" >
            <img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="formloader" style="width:60px;">
            </div>
													<span id="net_balance_amt"> - </span>
                              
                          </div>													
													</div>									
												
											</div>

											<div class="form-group">
												<label for="pay_for" >Pay for</label>
												<div>
													<select class="form-control userdropdown" name="pay_for" id="pay_for">
														<option value="">Select*</option> 
														<option value="flat_or_plot_payment">Flat/Plot Payment</option>
														<option value="maintenance">Apartment Maintenance Charges</option>
													</select>
													{!! $errors->first('pay_for', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
												<label for="amount">Amount</label>
												
													<div>
														
													<div class="input-group">
                              <span class="input-group-addon" id="amount"><i class="fa fa-rupee"></i></span>
                              <input type="text" class="form-control" name="amount" value="{{old('amount')}}" id="amount" required>
                          </div>
													{!! $errors->first('amount', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>                                                
                       </div>
                   </div>

									 <div class="box-footer ">
                
						<a href="{{ url('/customerzone/dashboard') }}" class="btn btn-warning pull-right">Cancel</a>
						<a id="paytobilldesk" class="btn btn-primary pull-right" style="margin-right:3px;" >Pay</a>
              </div>
                            
                                
                </form>
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('newcustomerzone.footer')
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
												$("#netbaldiv").hide();
												$("#paytobilldesk").on('click', function(e){
													e.preventDefault();
													$("#billdeskform").submit();
												});

									var data=<?php echo json_encode($getproject);?>;
													var length=data.length;
													var result="<option value=''>Select*</option>";
													var distinct=[];
													for(i=0;i<length;i++)
													{
														if($.inArray(data[i]['project_id'],distinct)===-1){
															distinct.push(data[i]['project_id']);
															result=result+"<option value='"+data[i]['project_id']+"'>"+data[i]['pname']+"</option>";
															
														}
														
													}
													$("#Projects").html(result);
													$("#Projects").on('change',function(){
														
														var result1="<option value=''>Select*</option>";
														//var distinct1=[];
														for(i=0;i<length;i++)
														{
															
															if($('#Projects').val()==data[i]['project_id'])
															{
																//if($.inArray(data[i]['project_id'],distinct1)===-1){
																//distinct1.push(data[i]['project_id']);
																result1=result1+"<option value='"+data[i]['unit']+"'>"+data[i]['unit_nm']+"</option>";
																
																//}
															}
														}
														$("#Units").html(result1);
													});

													$("#Units").on('change',function(){
														$("#netbaldiv").hide();

														var unitselected = $('#Units').val();
														var proejctselected = $('#Projects').val();
														if (unitselected != '') {

																$("#netbaldiv").show();
														$("#formloader1").show();
														$("#net_balance_amt").hide();

																$("#net_balance_amt").html('');
															$.post('/customerzone/getnetbalance', {"_token": "{{ csrf_token() }}",plantcode: proejctselected, unitcode: unitselected}, function(data){
																$("#formloader1").hide();
																if (data != -1) {
																	$("#net_balance_amt").show();
																	$("#net_balance_amt").html('<i class="fa fa-rupee"></i> ' + data);	
																}
																
															});

														}
																												
													});

														$("#Projects").on('change',function(){

															$("#netbaldiv").hide();
														var unitselected = $('#Units').val();
														var proejctselected = $('#Projects').val();
														if (unitselected != '') {
															$("#netbaldiv").show();
														$("#formloader1").show();
														$("#net_balance_amt").hide();

															$("#net_balance_amt").html('');
														$.post('/customerzone/getnetbalance', {"_token": "{{ csrf_token() }}",plantcode: proejctselected, unitcode: unitselected}, function(data){
															$("#formloader1").hide();
															if (data != -1) {
																$("#net_balance_amt").show();
																$("#net_balance_amt").html('<i class="fa fa-rupee"></i> ' + data);	
															}
															
														})
														}
														
														
													});
													
													
				});				
		    </script>
@endsection
