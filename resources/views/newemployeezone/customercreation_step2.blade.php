@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| MyDetails Customer Creation Step2 Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
<!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <script type="text/javascript" src="{{ asset('/newcustomerzoneassets/dist/js/defines.js') }}"></script>

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    #changedetailsForm label.col-sm-2{
        font-weight: 600;
    }
    label.col-sm-1{
        font-weight: 600;
    }
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user margin-r-5"></i> CUSTOMER CREATION </h3> <span class="pull-right" ><a href="{{ url('/employeezone/customercreationstep1') }}/{{$customer[0]['result']['leadno']}}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Back</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
              <?php echo "<script> setTimeout(function(){ window.location.href='{{url(\"/employeezone/customercreationstep2\")}}' }, 3000);</script>"; ?>
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
                
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/customercreationstep2') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                           @if(count($customer) > 0)
                              @foreach($customer as $customerdata)
                              
							
										
											<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Customer No / Name:</a>
												
												<?php
												//var_dump($customerdata);
													if ($customerdata['result']['Status2'] != '') {
												?>
											  	<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Customer Number</label>
														<div class="col-sm-4">
														<?php echo ltrim($customerdata['result']['Status2'], '0'); ?>
														</div>
														<div class="col-sm-4">
															<a class="btn btn-primary" href="{{url('/employeezone/saleorderconversion')}}">Convert to Sale Order</a>
														</div>
														<div class="col-sm-2"></div>
													</div>
													<?php
												}
													?>

													<?php
													if ($customerdata['result']['leadno'] != '') {
												?>
											  	<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Lead Number</label>
														<?php echo $customerdata['result']['leadno']; ?>
													</div>
													<?php
												}
													?>

					<?php
					 if ($customerdata['result']['Status2'] != '') {
					 if (isset($customerdata['result']['Title']) != '') { 
						?>
						<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Title*</label>
														<div class="col-sm-4">
											<?php echo $customerdata['result']['Title']; ?>						
														</div>
													</div>
								
								<?php }else{

									?>

									<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Title*</label>
														<div class="col-sm-4">
											<?php echo '-'; ?>						
														</div>
													</div>
								 <?php }

												 }
												 else
												 {
												 	?>
													
													<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Title*</label>
														<div class="col-sm-4">
															<select class="form-control userdropdown" name="reg[title]" id="title" required>
					
														<option value=''>Choose</option>
														<option value="0001">Ms.</option>
														<option value="0002">Mr.</option>
														<option value="0003">Company</option>
														<option value="0004">Mr. and Mrs.</option>
														<option value="0005">Mrs.</option>
														<option value="0006">Dr.</option>
														
													</select>
														</div>
													</div>

												 	<?php
												 }
												 
												?>

				<?php if ($customerdata['result']['Status2'] != '') {
												?>				

													<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Name*</label>
														<div class="col-sm-4">
															<?php
										if (isset($customerdata['result']['Name1']) != '') { echo $customerdata['result']['Name1'].' ';	}
										if (isset($customerdata['result']['Name2']) != '') { echo $customerdata['result']['Name2'].' ';	}
										if (isset($customerdata['result']['Name3']) != '') { echo $customerdata['result']['Name3'];	}
										if (isset($customerdata['result']['Name4']) != '') { echo $customerdata['result']['Name4'];	}

															?>
														</div>
													</div>
									<?php }
									else{
										?>
									<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Name*</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="reg[cname1]" id="tel" placeholder="Customer Name" maxlength="40" value="<?php echo $customerdata['result']['Name1'];  ?>" required>
															<input type="text" class="form-control" name="reg[cname2]" id="tel" maxlength="40" >
															<input type="text" class="form-control" name="reg[cname3]" id="tel" maxlength="40" >
															<input type="text" class="form-control" name="reg[cname4]" id="tel" maxlength="40" >
														</div>
													</div>
										<?php
									}
										?>

										<?php if ($customerdata['result']['Status2'] != '') {
												?>		

													<div class="form-group" style="padding:5px;">
														<label for="dob" class="col-sm-2">Date of birth*</label>
														<div class="col-sm-4">
															
															<?php
				if (isset($customerdata['result']['DOB']) != '') { echo substr($customerdata['result']['DOB'],0,4).'-'.substr($customerdata['result']['DOB'],4,2).'-'.substr($customerdata['result']['DOB'], 6,2);	}		?>											
				
														</div>
													</div>

									<?php
									}
									else
									{
										?>

										<div class="form-group" style="padding:5px;">
														<label for="dob" class="col-sm-2">Date of birth*</label>
														<div class="col-sm-4">
															
															
													<div class="input-prepend input-group ">
														<!--<span class="add-on input-group-addon">
															<i class="glyph-icon icon-calendar"></i>
														</span>-->
														<input type="text" class="form-control datepicker" id="dob" name="reg[dob]" required>
													</div>
													
				
														</div>
													</div>

										<?php
									}
										?>

										<?php if ($customerdata['result']['Status2'] != '') {

											if ((isset($customerdata['result']['Wedding_Anniversary_Day']) != '')&&(isset($customerdata['result']['Wedding_Anniversary_Day']) != '00000000')) {
												?>	
											
											<div class="form-group" style="padding:5px;">
														<label for="wedding_anniversary_day" class="col-sm-2">Wedding Anniversary Date</label>
														<div class="col-sm-4">
															
															
													<?php
													if (isset($customerdata['result']['Wedding_Anniversary_Day']) != '') { 
                                                        
                                                        echo substr($customerdata['result']['Wedding_Anniversary_Day'],0,4).'-'.substr($customerdata['result']['Wedding_Anniversary_Day'],4,2).'-'.substr($customerdata['result']['Wedding_Anniversary_Day'], 6,2);
                                                        }		?>
													
				
														</div>
													</div>
										<?php } ?>

												<?php
									}else
									{
										?>




										<div class="form-group" style="padding:5px;">
														<label for="wedding_anniversary_day" class="col-sm-2">Wedding Anniversary Date</label>
														<div class="col-sm-4">
															
															
													<div class="input-prepend input-group ">
														<!--<span class="add-on input-group-addon">
															<i class="glyph-icon icon-calendar"></i>
														</span>-->
														<input type="text" class="form-control datepicker" id="wedding_anniversary_day" name="reg[wedding_anniversary_day]" >
													</div>
													
				
														</div>
													</div>

										<?php
									}
										?>

													
													<?php if ($customerdata['result']['Status2'] != '') {
														?>
													
													<div class="form-group" style="padding:5px;">
														<label for="gender" class="col-sm-2">Gender*</label>
														<div class="col-sm-4">
															
															
												<?php
												if (isset($customerdata['result']['Gender1']) == 'X') {
													echo 'Male';
												}
												if (isset($customerdata['result']['Gender2']) == 'X') {
													echo 'Female';
												}
												?>													
				
														</div>
													</div>
										
														<?php
									}
									else
									{
										?>
										
										<div class="form-group" style="padding:5px;">
														<label for="gender" class="col-sm-2">Gender*</label>
														<div class="col-sm-4">
															
															
													<div class="radio">
													  <label><input type="radio" name="gender" value="male" checked="true">Male</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="gender" value="female">Female</label>
													</div>
													
				
														</div>
													</div>
										<?php
									}
										?>

										<?php if ($customerdata['result']['Status2'] != '') {
														?>

														<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Marital Status*</label>
														<div class="col-sm-4">
															
															<?php

												if (isset($customerdata['result']['Marital_Status1']) == 'X') {
																echo 'Single';
															}

												if (isset($customerdata['result']['Marital_Status2']) == 'X') {
																echo 'Married';
															}
															?>													
				
														</div>
													</div>
										
										<?php
									}else{
										?>
										<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Marital Status*</label>
														<div class="col-sm-4">
															
															
													<div class="radio">
													  <label><input type="radio" name="marital_status" value="single" checked="true">Single</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="marital_status" value="married">Married</label>
													</div>
													
				
														</div>
													</div>

										<?php
									}
										?>

										<?php if ($customerdata['result']['Status2'] != '') {
			if ((isset($customerdata['result']['Marital_Status3']) == 'X')||(isset($customerdata['result']['Marital_Status4']) == 'X')||(isset($customerdata['result']['Marital_Status5']) == 'X')||(isset($customerdata['result']['Marital_Status6']) == 'X')){
														?>
										

										<div class="form-group" style="padding:5px;" id="noofchildrend">
														<label class="col-sm-2">No. of children*</label>
														<div class="col-sm-4">
															
														<?php
										if (isset($customerdata['result']['Marital_Status3']) == 'X') {
															echo '1';
														}
										if (isset($customerdata['result']['Marital_Status4']) == 'X') {
															echo '2';
														}
										if (isset($customerdata['result']['Marital_Status5']) == 'X') {
															echo '3 and above';
														}
										if (isset($customerdata['result']['Marital_Status6']) == 'X') {
															echo 'None';
														}
														?>	
																										
				
														</div>
													</div>

										<?php
									}
									}else{
										?>	
									
									<div class="form-group" style="padding:5px;" id="noofchildren">
														<label class="col-sm-2">No. of children*</label>
														<div class="col-sm-4">
															
															
													<div class="radio">
													  <label><input type="radio" name="noofchildren"value="1">1</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="noofchildren" value="2">2</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="noofchildren" value="3andabove">3 and above</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="noofchildren" value="none" checked="true">none</label>
													</div>
													
				
														</div>
													</div>

										<?php
									}
										?>

													

											  </div>
											</div>

											<?php if ($customerdata['result']['Status2'] != '') {
						if ((isset($customerdata['result']['Search1']) != '')||(isset($customerdata['result']['Search2']) != '')){
												?>	

				<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Search:</a>
													
													
												<div class="form-group" style="padding:5px;">
														<label for="search1" class="col-sm-2">Search term 1/2</label>

														<?php
										if (isset($customerdata['result']['Search1']) != '') {
														
															echo '<div class="col-sm-4">'.$customerdata['result']['Search1'].'</div>';
														}

										if (isset($customerdata['result']['Search2']) != '') {
															echo '<div class="col-sm-4">'.$customerdata['result']['Search2'].'</div>';
														}
														?>
													</div>
												
											  	</div>
											  	</div>

												<?php
											}
									}else{
										?>

								<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Search:</a>
													
													
												<div class="form-group" style="padding:5px;">
														<label for="search1" class="col-sm-2">Search term 1/2</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="reg[search1]" id="search1" >
														</div>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="reg[search2]" id="search2">
														</div>
													</div>
												
											  	</div>
											  	</div>
										<?php
									}
										?>

											


											  	<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Street Address:</a>
													
													
												<div class="form-group" style="padding:5px;">
														<label for="buildcode" class="col-sm-2">Building Code</label>

														<div class="col-sm-2">
												<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Building_Code']) != '') {
															
															echo $customerdata['result']['Building_Code'];
												 }else{ echo '-'; } }else{ ?>
												<input type="text" class="form-control" name="reg[buildcode]" id="buildcode">

												<?php } ?>
														</div>

														<label for="room" class="col-sm-1">Room</label>
														<div class="col-sm-2">

					<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Room']) != '') {
															
								echo $customerdata['result']['Room'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[room]" id="room">
								<?php } ?>

														</div>
														<label for="floor" class="col-sm-1">Floor</label>
														<div class="col-sm-2">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Floor']) != '') {
															
								echo $customerdata['result']['Floor'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[floor]" id="floor">
									<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="co" class="col-sm-2">c/o</label>
														<div class="col-sm-8">

															<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['C_O']) != '') {
															
								echo $customerdata['result']['C_O'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[co]" id="co" >
											<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="street1" class="col-sm-2">Street 2*</label>
														<div class="col-sm-8">
											<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street1']) != '') {
															
								echo $customerdata['result']['Street1'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street1]" id="street1" maxlength="50" required>
															<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="street3" class="col-sm-2">Street 3*</label>
														<div class="col-sm-8">
															<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street2']) != '') {
															
								echo $customerdata['result']['Street2'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street2]" id="street2" required>
															<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="street3" class="col-sm-2">Street/House Number*</label>
														<div class="col-sm-4">
													<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street3']) != '') {
															
								echo $customerdata['result']['Street3'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street3]" id="street3" required>
															<?php } ?>
														</div>
														<div class="col-sm-1">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['House_Number']) != '') {
															
								echo ' / '.$customerdata['result']['House_Number'];
								 }else{ echo ' / '.'-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[houseno]" id="houseno">
															<?php } ?>
														</div>
														<label for="suppl" class="col-sm-1">Suppl</label>
														<div class="col-sm-4">
															<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street4']) != '') {
															
								echo $customerdata['result']['Street4'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street4]" id="street4">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="street4" class="col-sm-2">Street 4*</label>
														<div class="col-sm-8">
															<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street5']) != '') {
															
								echo $customerdata['result']['Street5'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street5]" id="street5" required>
											<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="street5" class="col-sm-2">Street 5*</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Street6']) != '') {
															
								echo $customerdata['result']['Street6'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[street6]" id="street6" required>
														<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="district" class="col-sm-2">District</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['District']) != '') {
															
								echo $customerdata['result']['District'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[district]" id="district">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="resstatus" class="col-sm-2">Resident Status</label>
														<div class="col-sm-4">
															
															<?php
							if ($customerdata['result']['Status2'] != '') {
									
								if (isset($customerdata['result']['Resident_Indian1']) == 'X') {
															
								echo 'Resident Indian';
								 }
								 if (isset($customerdata['result']['Resident_Indian2']) == 'X') {
															
								echo 'Non Resident Indian';
								 }
								 if (isset($customerdata['result']['Resident_Indian3']) == 'X') {
															
								echo 'Non Person of Indian Origin';
								 }

								  }else{ ?>
													<div class="radio">
													  <label><input type="radio" name="resstatus" value="residentindian" checked="true">Resident Indian</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="resstatus" value="nonresidentindian">Non Resident Indian</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="resstatus" value="nonpersonofindian">Non Person of Indian Origin</label>
													</div>
													<?php } ?>
				
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="empstatus" class="col-sm-2">Employment Status</label>
														<div class="col-sm-4">
															
															<?php
							if ($customerdata['result']['Status2'] != '') {
									
								if (isset($customerdata['result']['Employment1']) == 'X') {
															
								echo 'Salaried';
								 }
								 if (isset($customerdata['result']['Employment2']) == 'X') {
															
								echo 'Self Employed';
								 }
								 if (isset($customerdata['result']['Employment3']) == 'X') {
															
								echo 'Retired';
								 }

								  }else{ ?>
													<div class="radio">
													  <label><input type="radio" name="empstatus" value="salaried" checked="true">Salaried</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="empstatus" value="selfemployed">Self Employed</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="empstatus" value="retired">Retired</label>
													</div>
													
													<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="diffcity" class="col-sm-2">Different City</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Different_City']) != '') {
															
								echo $customerdata['result']['Different_City'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[diffcity]" id="diffcity">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="postalcode" class="col-sm-2">Postal Code/City*</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Postal_code']) != '') {
															
								echo $customerdata['result']['Postal_code'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[postalcode]" id="postalcode"minlength="6" maxlength="6" onkeypress="return isNumberKey(this)" required>
															<?php } ?>
														</div>
														

														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['City']) != '') {
															
								echo $customerdata['result']['City'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[city]" id="city"  required>
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="country" class="col-sm-2">Country</label>
														<div class="col-sm-5">
														
														<?php
							if ($customerdata['result']['Status2'] != '') {
								?>
								<select class="form-control" name="country" id="country" country="true" default="<?php echo $customerdata['result']['Country']; ?>" disabled>
															
															</select>
								<?php
								  }else{ ?>
															<select class="form-control" name="country" id="country" country="true" default="IN" required>
															<option value="">Select*</option>
															</select>
														<?php } ?>
														</div>
														<label for="region" class="col-sm-1">Region</label>
														<div class="col-sm-4">
																	<?php
							if ($customerdata['result']['Status2'] != '') {
								?>
								<select class="form-control" name="region" id="state" state="true" default="<?php echo $customerdata['result']['Region']; ?>" disabled>
															
															</select>
								<?php
								  }else{ ?>
															<select class="form-control" name="region" id="state" state="true" default="22"required>
															</select>
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="timezone" class="col-sm-2">Timezone</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Time_Zone']) != '') {
															
								echo $customerdata['result']['Time_Zone'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[timezone]" id="timezone">
															<?php } ?>
														</div>
														<label for="jurisdiction" class="col-sm-1">Tax Jurisdiction</label>
														<div class="col-sm-4">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Tax_Jurisdictn']) != '') {
															
								echo $customerdata['result']['Tax_Jurisdictn'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[jurisdiction]" id="jurisdiction">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="transpzone" class="col-sm-2">Transportation Zone</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Transportation_Zone']) != '') {
															
								echo $customerdata['result']['Transportation_Zone'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[transpzone]" id="transpzone">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="regstructgrp" class="col-sm-2">Reg. Struct. Grp.</label>
														<div class="col-sm-8">
																				<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Reg_Struct_Grp']) != '') {
															
								echo $customerdata['result']['Reg_Struct_Grp'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[regstructgrp]" id="regstructgrp" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="undeliverable1" class="col-sm-2">Undeliverable</label>
														<div class="col-sm-4">
															<?php
							if ($customerdata['result']['Status2'] != '') {
								if (isset($customerdata['result']['Undeliverable']) != '') {

									$undeliverable1 = $customerdata['result']['Undeliverable'];

						if ($undeliverable1 == '0009') { echo 'Company Wound-up'; }
						if ($undeliverable1 == '0008') { echo 'Deceased'; }
						if ($undeliverable1 == '0004') { echo 'Illegible Address'; }
						if ($undeliverable1 == '0003') { echo 'Inadequate Address'; }
						if ($undeliverable1 == '0002') { echo 'Moved w/o Forwarding Address'; }
						if ($undeliverable1 == '0005') { echo 'No Letter box'; }
						if ($undeliverable1 == '0006') { echo 'No Po Box'; }
						if ($undeliverable1 == '0007') { echo 'Rejected'; }
						if ($undeliverable1 == '0001') { echo 'Unknown'; }

								
								  } else{ echo '-';} }else{ ?>
															<select class="form-control userdropdown" name="undeliverable1" id="undeliverable1" >
														
														<option value="">Select</option>
														<option value="0009">Company Wound-up</option>
														<option value="0008">Deceased</option>
														<option value="0004"> Illegible Address</option>
														<option value="0003">Inadequate Address</option>
														<option value="0002"> Moved w/o Forwarding Address</option>
														<option value="0005">No Letter box</option>
														<option value="0006">No Po Box</option>
														<option value="0007">Rejected</option>
														<option value="0001">Unknown</option>
														
													</select>
													<?php } ?>
														</div>
													</div>
												
											  	</div>
											  	</div>


											  	<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">PO Box Address:</a>
													
													<div class="form-group" style="padding:5px;">
														<label for="poboxaddress" class="col-sm-2">PO Box</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Box1']) != '') {
															
								echo $customerdata['result']['PO_Box1'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[poboxaddress]" id="poboxaddress" >
															<?php } ?>
														</div>
														<label for="poboxaddresswono" class="col-sm-1">PO Box w/o no.</label>
														<div class="col-sm-1">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Box2']) != '') {
															?>
															<div class="checkbox">
								<input type="checkbox" name="poboxaddresswono" id="poboxaddresswono"  checked="true" disabled="true" style="width: 15px;">
								</div>
								<?php
								 }else{ echo '-'; } }else{ ?>

                                    <div class="checkbox">
                                    
															<input type="checkbox"   name="poboxaddresswono" id="poboxaddresswono" value="tick" style="width: 15px;">
                                                            </div>
															<?php } ?>
														</div>
													</div>
													<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2"></label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
								if (isset($customerdata['result']['PO_Box3']) != '') {

									$PO_Box3 = $customerdata['result']['PO_Box3'];

						if ($PO_Box3 == '1') { echo 'Private Bag'; }
						if ($PO_Box3 == '2') { echo 'Response Bag'; }
						if ($PO_Box3 == '3') { echo 'Locked Bag'; }
						if ($PO_Box3 == '4') { echo 'Community Mail Box'; }
						if ($PO_Box3 == '5') { echo 'Counter Delivery'; }
						if ($PO_Box3 == '6') { echo 'General Delivery'; }
						if ($PO_Box3 == '7') { echo 'Poste Restante'; }
						

								
								  } else{ echo '-';} }else{ ?>
															<select class="form-control userdropdown" name="postbox1" id="postbox1" >
														
														<option value="">Select</option>
														<option value="1">Private Bag</option>
														<option value="2">Response Bag</option>
														<option value="3">Locked Bag</option>
														<option value="4">Community Mail Box</option>
														<option value="5">Counter Delivery</option>
														<option value="6">General Delivery</option>
														<option value="7">Poste Restante</option>
														
														
													</select>
													<?php } ?>
														</div>
														<label for="postbox2" class="col-sm-1"></label>
														<div class="col-sm-4">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Box4']) != '') {
															
								echo $customerdata['result']['PO_Box4'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[postbox2]" id="postbox2" value="">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="postboxlobby" class="col-sm-2">PO Box Lobby</label>
														<div class="col-sm-8">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Box_Lobby']) != '') {
															
								echo $customerdata['result']['PO_Box_Lobby'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[postboxlobby]" id="postboxlobby" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Postal code</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Postal_Code']) != '') {
															
								echo $customerdata['result']['Postal_Code'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[popostalcode]" id="popostalcode" minlength="6" maxlength="6" onkeypress="return isNumberKey(this)">
															<?php } ?>
														</div>
														<label for="poboxcity" class="col-sm-1">PO Box City</label>
														<div class="col-sm-4">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Box_City']) != '') {
															
								echo $customerdata['result']['PO_Box_City'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[poboxcity]" id="poboxcity">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="othercountry" class="col-sm-2">Other Country</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Other_Country']) != '') {
															
								echo $customerdata['result']['Other_Country'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[othercountry]" id="othercountry">
															<?php } ?>
														</div>
														<label for="poboxregion" class="col-sm-1">PO Region</label>
														<div class="col-sm-4">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['PO_Region']) != '') {
															
								echo $customerdata['result']['PO_Region'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[poboxregion]" id="poboxregion" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="companypostalcode" class="col-sm-2">Company Postal code</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Company_Postal_Code']) != '') {
															
								echo $customerdata['result']['Company_Postal_Code'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[companypostalcode]" id="companypostalcode" minlength="6" maxlength="6" onkeypress="return isNumberKey(this)">
															<?php } ?>
														</div>
														<label for="inputPassword3" class="col-sm-1"></label>
														<div class="col-sm-2">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Post1']) != '') {
															
								echo $customerdata['result']['Post1'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[companypostalcode2]" id="tel" >
															<?php } ?>
														</div>
														<div class="col-sm-2">
														<?php
							if ($customerdata['result']['Status2'] != '') {
									if (isset($customerdata['result']['Post2']) != '') {
															
								echo $customerdata['result']['Post2'];
								 }else{ echo '-'; } }else{ ?>
															<input type="text" class="form-control" name="reg[companypostalcode3]" id="tel" >
															<?php } ?>
														</div>
													</div>
												
													<div class="form-group" style="padding:5px;">
														<label for="undeliverable2" class="col-sm-2">Undeliverable</label>
														<div class="col-sm-4">
													
													<?php
							if ($customerdata['result']['Status2'] != '') {
								if (isset($customerdata['result']['Undeliverable1']) != '') {

									$undeliverable2 = $customerdata['result']['Undeliverable1'];

						if ($undeliverable2 == '0009') { echo 'Company Wound-up'; }
						if ($undeliverable2 == '0008') { echo 'Deceased'; }
						if ($undeliverable2 == '0004') { echo 'Illegible Address'; }
						if ($undeliverable2 == '0003') { echo 'Inadequate Address'; }
						if ($undeliverable2 == '0002') { echo 'Moved w/o Forwarding Address'; }
						if ($undeliverable2 == '0005') { echo 'No Letter box'; }
						if ($undeliverable2 == '0006') { echo 'No Po Box'; }
						if ($undeliverable2 == '0007') { echo 'Rejected'; }
						if ($undeliverable2 == '0001') { echo 'Unknown'; }

								
								  } else{ echo '-';} }else{ ?>
															<select class="form-control userdropdown" name="undeliverable2" id="undeliverable2" >
														
														<option value="">Select</option>
														<option value="0009">Company Wound-up</option>
														<option value="0008">Deceased</option>
														<option value="0004"> Illegible Address</option>
														<option value="0003">Inadequate Address</option>
														<option value="0002"> Moved w/o Forwarding Address</option>
														<option value="0005">No Letter box</option>
														<option value="0006">No Po Box</option>
														<option value="0007">Rejected</option>
														<option value="0001">Unknown</option>
														
													</select>
													<?php } ?>

														</div>
													</div>

													</div>
													</div>


													<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Industry Status:</a>


											  	<div class="form-group" style="padding:5px;">
														
												<?php
							if ($customerdata['result']['Status2'] != '') {
								?>

													<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus1" <?php 
													  if (isset($customerdata['result']['Industry1']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">IT/Non IT</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus6" <?php 
													  if (isset($customerdata['result']['Industry6']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Telecom</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus11" <?php 
													  if (isset($customerdata['result']['Industry11']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Hospitality</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus2" <?php 
													  if (isset($customerdata['result']['Industry2']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Banking</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus7" <?php 
													  if (isset($customerdata['result']['Industry7']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">FCMG</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus12" <?php 
													  if (isset($customerdata['result']['Industry12']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Govt.</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus3" <?php 
													  if (isset($customerdata['result']['Industry3']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Insurance</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus8" <?php 
													  if (isset($customerdata['result']['Industry8']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">NGO's</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus13" <?php 
													  if (isset($customerdata['result']['Industry13']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Education</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus4" <?php 
													  if (isset($customerdata['result']['Industry4']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Real Estate</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus9" <?php 
													  if (isset($customerdata['result']['Industry9']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Avitation</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus14" <?php 
													  if (isset($customerdata['result']['Industry14']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Teaching</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus5" <?php 
													  if (isset($customerdata['result']['Industry5']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Retail</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus10" <?php 
													  if (isset($customerdata['result']['Industry10']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Automobile</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus15" <?php 
													  if (isset($customerdata['result']['Industry15']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Others</label>
													</div>
														</div>


							
			<?php

									 }else{ ?>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus1" checked="true">IT/Non IT</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus6">Telecom</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus11">Hospitality</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus2">Banking</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus7">FCMG</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus12">Govt.</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus3" >Insurance</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus8">NGO's</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus13">Education</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus4" >Real Estate</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus9">Avitation</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus14">Teaching</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus5" >Retail</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus10">Automobile</label>
													</div>

													<div class="radio">
													  <label><input type="radio" name="industrystatus" value="indus15">Others</label>
													</div>
														</div>
													
													<?php } ?>
													</div>

											  	</div>
											  	</div>


											  	<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Gross Income(Rs.) (Per Annum)</a>


											  	<div class="form-group" style="padding:5px;">
													

									<?php

							if ($customerdata['result']['Status2'] != '') {
								?>


								<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross1" <?php 
													  if (isset($customerdata['result']['Gross1']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">0-3 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross4" <?php 
													  if (isset($customerdata['result']['Gross4']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">12-18 Lakhs</label>
													</div>

														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross2" <?php 
													  if (isset($customerdata['result']['Gross2']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">3-6 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross5" <?php 
													  if (isset($customerdata['result']['Gross5']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">18-24 Lakhs</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross3" <?php 
													  if (isset($customerdata['result']['Gross3']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">6-12 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross6" <?php 
													  if (isset($customerdata['result']['Gross6']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">24-48 Lakhs</label>
													</div>
														</div>

														<div class="col-sm-2">
													
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross7" <?php 
													  if (isset($customerdata['result']['Gross7']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">48 Lakhs and above</label>
													</div>
														</div>

								
			<?php

									 }else{ ?>	
														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross1" checked="true">0-3 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross4">12-18 Lakhs</label>
													</div>

														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross2">3-6 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross5">18-24 Lakhs</label>
													</div>
														</div>

														<div class="col-sm-2">
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross3" >6-12 Lakhs</label>
													</div>
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross6">24-48 Lakhs</label>
													</div>
														</div>

														<div class="col-sm-2">
													
													<div class="radio">
													  <label><input type="radio" name="grossincome" value="gross7">48 Lakhs and above</label>
													</div>
														</div>

														<?php } ?>				

													</div>

											  	</div>
											  	</div>

											
											<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Vehicle Details</a>

											  	<div class="form-group" style="padding:5px;">
														
														<div class="col-sm-4">
															
														<?php
							if ($customerdata['result']['Status2'] != '') {

								?>
								<div class="checkbox">
													  <label><input type="checkbox" name="vehicledetails1" value="two" <?php 
													  if (isset($customerdata['result']['Vehicle1']) == 'X') { ?> checked="true" <?php } ?>  disabled="true">Four Wheeler</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" name="vehicledetails2" <?php 
													  if (isset($customerdata['result']['Vehicle2']) == 'X') { ?> checked="true" <?php } ?>  disabled="true" value="four">Two Wheeler</label>
													</div>

								

				<?php
									 }else{ ?>	
													<div class="checkbox">
													  <label><input type="checkbox" name="vehicledetails1" value="two" >Four Wheeler</label>
													</div>
													<div class="checkbox">
													  <label><input type="checkbox" name="vehicledetails2" value="four">Two Wheeler</label>
													</div>											
													<?php } ?>
														</div>
													</div>

											  	</div>
											  	</div>

											  	<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Communication</a>

											  	<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Language</label>

														
														<div class="col-sm-5">
														<?php echo 'English'; ?>
															<input type="hidden" class="form-control" name="reg[lang]" id="lang" minlength="3" maxlength="10" value="<?php echo $customerdata['result']['Language']; ?>" readonly required>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="inputPassword3" class="col-sm-2">Telephone</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Telephone']) != '') { echo $customerdata['result']['Telephone'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[telephone]" id="telephone" minlength="10" maxlength="20">
										<?php } ?>
														</div>
														<label for="inputPassword3" class="col-sm-1">Extension</label>
														<div class="col-sm-4">
							<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Extension']) != '') { echo $customerdata['result']['Extension'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[telephone_ext]" id="telephone_ext" minlength="3" maxlength="6">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="mobile" class="col-sm-2">Mobile Phone</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Mobile_Phone']) != '') { echo $customerdata['result']['Mobile_Phone'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[mobile]" id="mobile" value="<?php echo $customerdata['result']['Mobile_Phone']; ?>" minlength="10" maxlength="20" required>
															<?php } ?>
														</div>
														
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="fax" class="col-sm-2">Fax</label>
														<div class="col-sm-5">
																	<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Fax']) != '') { echo $customerdata['result']['Fax'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[fax]" id="fax" >
									<?php } ?>
														</div>
														<label for="faxext" class="col-sm-1">Extension</label>
														<div class="col-sm-4">
																		<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Extension1']) != '') { echo $customerdata['result']['Extension1'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[faxext]" id="faxext" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="email" class="col-sm-2">Email</label>
														<div class="col-sm-5">
																			<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['E_Mail']) != '') { echo $customerdata['result']['E_Mail'];}
			
			else{ echo "-";} }else{ ?>
															<input type="email" class="form-control" name="reg[email]" id="email" value="<?php echo $customerdata['result']['E_Mail']; ?>" required>
															<?php } ?>
														</div>
														
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="comm_method" class="col-sm-2">Comm. Method</label>
														<div class="col-sm-5">
													<?php
							if ($customerdata['result']['Status2'] != '') {
								if (isset($customerdata['result']['Comm_Method1']) != '') {

									$Comm_Method1 = $customerdata['result']['Comm_Method1'];

						if ($Comm_Method1 == 'FAX') { echo 'fax'; }
						if ($Comm_Method1 == 'INT') { echo 'E-Mail'; }
						if ($Comm_Method1 == 'LET') { echo 'Post (letter)'; }
						if ($Comm_Method1 == 'PAG') { echo 'Pager/SMS'; }
						if ($Comm_Method1 == 'PRT') { echo 'Printer'; }
						if ($Comm_Method1 == 'RML') { echo 'Remote Mail'; }
						if ($Comm_Method1 == 'SSF') { echo 'Secure Store & Forw.'; }
						

								
								  } else{ echo '-';} }else{ ?>
															<select class="form-control userdropdown" name="comm_method" id="comm_method">
														
														<option value="">Select</option>
														<option value="FAX">fax</option>
														<option value="INT">E-Mail</option>
														<option value="LET">Post (letter)</option>
														<option value="PAG">Pager/SMS</option>
														<option value="PRT">Printer</option>
														<option value="RML">Remote Mail</option>
														<option value="SSF">Secure Store & Forw.</option>
														<option value="TEL">Telephone</option>
														<option value="TLX">Telex</option>
														<option value="TTX">Teletex</option>

														</select>
									<?php } ?>
														</div>
														
													</div>

													<div class="form-group" style="padding:5px;">
														
														<div class="col-sm-5 col-sm-offset-2">
															<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Comm_Method2']) != '') { echo $customerdata['result']['Comm_Method2'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[comm_metho2]" id="comm_metho2">
															<?php } ?>
														</div>
														
													</div>
													<div class="form-group" style="padding:5px;">
														
														<div class="col-sm-5 col-sm-offset-2">
															<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Comm_Method3']) != '') { echo $customerdata['result']['Comm_Method3'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[comm_metho3]" id="comm_metho3">
															<?php } ?>
														</div>
														
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="comments" class="col-sm-2">Comments</label>
														<div class="col-sm-5">
																<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Comments']) != '') { echo $customerdata['result']['Comments'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[comments]" id="comments">
															<?php } ?>
														</div>
														
													</div>

											  	</div>
											  	</div>

											  	<div class="panel panel-default">
											  <div class="panel-body">
											  	
											  	<a href="#" class="btn btn-danger btn-xs">Co Applicants</a>
												
												<div class="form-group" style="padding:5px;">
														<label for="coapp1" class="col-sm-2">Co Applicants 1</label>
														<div class="col-sm-5">
															<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Co_Applicant1']) != '') { echo $customerdata['result']['Co_Applicant1'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[coapp1]" id="coapp1" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="coapp2" class="col-sm-2">Co Applicants 2</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Co_Applicant2']) != '') { echo $customerdata['result']['Co_Applicant2'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[coapp2]" id="coapp2" >
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="coapp3" class="col-sm-2">Co Applicants 3</label>
														<div class="col-sm-5">
														<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Co_Applicant3']) != '') { echo $customerdata['result']['Co_Applicant3'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[coapp3]" id="coapp3">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
														<label for="coapp4" class="col-sm-2">Co Applicants 4</label>
														<div class="col-sm-5">
															<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (isset($customerdata['result']['Co_Applicant4']) != '') { echo $customerdata['result']['Co_Applicant4'];}
			
			else{ echo "-";} }else{ ?>
															<input type="text" class="form-control" name="reg[coapp4]" id="coapp4">
															<?php } ?>
														</div>
													</div>

													<div class="form-group" style="padding:5px;">
												<label for="panno" class="col-sm-2">PAN Number</label>
												<div class="col-sm-5">
													<?php
							if ($customerdata['result']['Status2'] != '') {
								
			if (!empty($customerdata['result']['PAN_No'])) { echo $customerdata['result']['PAN_No'];}
			
			else{ echo "-";} }else{ ?>
													<input type="text" class="form-control" name="reg[panno]" id="panno" value="<?php echo $customerdata['result']['PAN_No']; ?>" placeholder="PAN No" disabled="true">
													<?php } ?>
												</div>
											</div>
											<div class="form-group" style="padding:5px;">
												<label for="passportno" class="col-sm-2">Passport Number</label>
												<div class="col-sm-5">
												<?php
												
							if ($customerdata['result']['Status2'] != '') {
								
	if (!empty($customerdata['result']['Passport'])) { echo $customerdata['result']['Passport'];}
			else{ echo "-";} }else{ ?>
													<input type="text" class="form-control" name="reg[passportno]" id="passportno" value="<?php echo $customerdata['result']['Passport']; ?>"  placeholder="Passport No" disabled="true">
													<?php } ?>
												</div>
											</div>

											  	</div>
											  	</div>

											<br>
											<?php
							if ($customerdata['result']['Status2'] != '') {
								
			 }else{ ?>
											
											<div class="form-group">
												<div class="col-sm-2"></div>
												<div class="col-sm-4"> 
													<input class="submitbtn btn btn-warning" style="float: left;" type="submit" value="Convert to Customer">
													
												</div> 
											</div>
											<br/>
											<br/>
											<?php } ?>
										
                              @endforeach
                               
                           @endif            
                                 
                                     
                                             
                       </div>
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

@include('newemployeezone.footer')
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<!-- InputMask -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>

    $(document).ready(function(){
				$(".time").attr('disabled',true);
				$(".time-row").css('display','none');
				$(".time-label").css('opacity','0.5');
				$(".userdropdown").change(function() {
					if ($(this).val() == "Half Day" || $(this).val() == "CL - Half" || $(this).val() == "SL - Half" ) {
						$(".time").attr('disabled', false);	
						$(".time-row").css('display','block');
						$(".time-label").css('opacity','1');
					}
					else{
						$(".time").attr('disabled', true);	
						$(".time").attr('checked', false);
						$(".time-row").css('display','none');
					}	
				});
			/*$(".datepicker").datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: '1900:2050',
					dateFormat:'yy-mm-dd',
				});*/
        $('.datepicker').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })

$("#noofchildren").css("display", "none");
   $('input[type=radio][name=marital_status]').change(function() {
        if (this.value == 'single') {
            
            $("#noofchildren").css("display", "none");

        }
        else if (this.value == 'married') {
            $("#noofchildren").css("display", "block");
        }
    });


   	var country='<option value="">Select*</option>';
   	console.log(countries);
						$.each( countries, function( i, val ) {
							country += '<option value="'+val['c_id']+'"';
							if(val['c_id']==$('select[country]').attr('default'))
							country+=' selected ';
							country+='>'+val['c_nm']+'</option>';	
						});
											
					$('select[country]').html(country);	
						genArea();
						$('select[country]').on('change',function(){genArea();})
							function genArea()
							{
				    	var parent=$('select[country]').val();													
						var output='<option value="">Select*</option>';
							$.each( states, function( i, val ) {
									if(val['c_id']==parent)
									{	
								output += '<option value="'+val['s_id']+'"';
								if(val['s_id']==$('select[state]').attr('default'))
										output+=' selected ';
								output+='>'+val['s_nm']+'</option>';
									}  
								$('select[state]').html(output);
								});
						};


			});
    
</script>
@endsection
